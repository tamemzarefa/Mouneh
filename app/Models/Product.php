<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favoredByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('primary')->singleFile();
        $this->addMediaCollection('gallery');
    }

    // Conversions can be added after Spatie Image is installed.

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Accessors for views
    public function getThumbUrlAttribute(): ?string
    {
        $thumb = method_exists($this, 'getFirstMediaUrl')
            ? ($this->getFirstMediaUrl('primary', 'thumb') ?: $this->getFirstMediaUrl('gallery', 'thumb'))
            : null;
        if (!$thumb) {
            $primaryOld = optional($this->images)->sortBy('sort_order')->first();
            $thumb = $primaryOld ? asset($primaryOld->url) : null;
        }
        return $thumb ?: null;
    }

    public function getStatusLabelArAttribute(): string
    {
        $status = $this->status ?: null;
        if ($status === 'approved') { return 'مقبول'; }
        if ($status === 'pending') { return 'قيد المراجعة'; }
        if ($status === 'rejected') { return 'مرفوض'; }
        return '-';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        $status = $this->status ?: null;
        if ($status === 'approved') { return 'badge badge-success'; }
        if ($status === 'pending') { return 'badge'; }
        if ($status === 'rejected') { return 'badge'; }
        return 'badge';
    }

    public function getStatusBadgeStyleAttribute(): ?string
    {
        return ($this->status === 'rejected') ? 'background:#fde2e2;color:#8a1c1c;' : null;
    }
}

