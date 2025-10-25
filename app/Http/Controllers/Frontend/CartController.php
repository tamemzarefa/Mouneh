<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\OrderCreated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $cart = Cart::with(['items.product'])->firstOrCreate(['user_id' => $user->id]);
        $items = $cart->items->map(function (CartItem $item) {
            $subtotal = $item->quantity * $item->unit_price_cents;
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'title' => optional($item->product)->title_ar,
                'quantity' => $item->quantity,
                'unit_price_cents' => $item->unit_price_cents,
                'subtotal_cents' => $subtotal,
            ];
        });
        $totalCents = $items->sum('subtotal_cents');

        return view('frontend.cart', [
            'items' => $items,
            'totalCents' => $totalCents,
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'quantity' => ['nullable','integer','min:1']
        ]);

        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $qty = $data['quantity'] ?? 1;
        $product = Product::findOrFail($data['product_id']);

        // Block adding products that are not approved or inactive
        if (method_exists($product, 'status') || property_exists($product, 'status')) {
            if (($product->status ?? null) !== 'approved' || !$product->is_active) {
                return back()->with('status', 'هذا المنتج غير متاح حالياً');
            }
        }

        // Check stock availability
        if ($product->stock < $qty) {
            return back()->withErrors([
                'stock' => "الكمية المطلوبة غير متوفرة. المتوفر: {$product->stock}"
            ]);
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        if (!$item->exists) {
            $item->quantity = 0;
            $item->unit_price_cents = $product->price_cents;
        }

        $item->quantity += $qty;
        $item->save();

        return back()->with('status', 'تمت إضافة المنتج إلى السلة');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Require user to select a payment provider (payment method)
        $data = $request->validate([
            'payment_provider' => ['required', 'in:manual,cod,bank_transfer,wallet']
        ]);

        $cart = Cart::with(['items.product.seller'])->firstOrCreate(['user_id' => $user->id]);
        if ($cart->items->isEmpty()) {
            return back()->with('status', 'السلة فارغة');
        }

        // Check stock availability before checkout
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->withErrors([
                    'stock' => "الكمية المطلوبة من {$item->product->title_ar} غير متوفرة. المتوفر: {$item->product->stock}"
                ]);
            }
        }

        $address = Address::where('user_id', $user->id)->where('is_default', true)->first()
            ?: Address::where('user_id', $user->id)->first();
        if (!$address) {
            return back()->with('status', 'يرجى إضافة عنوان توصيل قبل إتمام الطلب');
        }

        $groups = $cart->items->groupBy(function (CartItem $item) {
            return optional($item->product)->seller_id;
        });

        foreach ($groups as $sellerId => $items) {
            if (!$sellerId) { continue; }
            $subtotal = $items->sum(function (CartItem $it) { return $it->quantity * $it->unit_price_cents; });
            $order = Order::create([
                'buyer_id' => $user->id,
                'seller_id' => $sellerId,
                'address_id' => $address->id,
                'status' => 'pending',
                'subtotal_cents' => $subtotal,
                'shipping_cents' => 0,
                'discount_cents' => 0,
                'total_cents' => $subtotal,
                'currency' => 'SYP',
            ]);

            foreach ($items as $it) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $it->product_id,
                    'quantity' => $it->quantity,
                    'unit_price_cents' => $it->unit_price_cents,
                ]);
            }

            // Create payment record for each order with selected provider
            Payment::create([
                'order_id' => $order->id,
                'provider' => $data['payment_provider'],
                'status' => 'pending',
                'amount_cents' => $subtotal,
                'currency' => 'SYP',
            ]);

            // Notify buyer and seller
            try {
                // Buyer notification
                $user->notify(new OrderCreated($order, 'buyer'));
                // Seller notification
                if ($seller = User::find($sellerId)) {
                    $seller->notify(new OrderCreated($order, 'seller'));
                }
            } catch (\Throwable $e) {
                // Swallow notification errors to not block checkout
                \Log::warning('OrderCreated notification failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            }
        }

        // Clear cart after creating orders
        $cart->items()->delete();

        return redirect()->route('orders.index')->with('status', 'تم إرسال الطلب بنجاح! يمكنك تتبع حالة طلبك من صفحة الطلبات');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99']
        ]);

        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Ensure the cart item belongs to the user
        if ($cartItem->cart->user_id !== $user->id) {
            abort(403);
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return back()->with('status', 'تم تحديث الكمية');
    }

    public function remove(Request $request, CartItem $cartItem): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Ensure the cart item belongs to the user
        if ($cartItem->cart->user_id !== $user->id) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('status', 'تم حذف المنتج من السلة');
    }
}
