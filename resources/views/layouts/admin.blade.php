<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="mouneh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - Mouneh</title>
    @vite('resources/css/app.css')
</head>
<body class="theme-bg theme-text">
    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col min-h-screen">
            <!-- Navbar -->
            <div class="sticky top-0 z-30">
                <div class="navbar theme-surface border-b theme-border backdrop-blur-sm bg-base-100/80">
                    <div class="flex-none lg:hidden">
                        <label for="admin-drawer" class="btn btn-ghost btn-square hover:bg-base-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </label>
                    </div>
                    <div class="flex-1">
                        <a href="/admin" class="inline-flex items-center gap-3 hover:opacity-80 transition-opacity">
                            <div class="relative">
                                <img src="{{ asset('images/logo.png') }}" alt="Mouneh" class="h-8 w-auto rounded-lg shadow-sm" />
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-success rounded-full animate-pulse"></div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">لوحة التحكم</span>
                                <span class="text-xs text-base-content/60">Mouneh Admin</span>
                            </div>
                        </a>
                    </div>
                    <div class="flex-none gap-3">
                        <div class="form-control hidden md:block">
                            <div class="relative">
                                <input type="text" placeholder="بحث في النظام..." class="input input-bordered w-44 md:w-72 pl-10 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                        <button id="themeToggle" class="btn btn-ghost btn-square hover:bg-base-200 transition-colors" title="تبديل النمط">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M21.752 15.002A9.718 9.718 0 0 1 12 21.75c-5.385 0-9.75-4.365-9.75-9.75 0-4.136 2.636-7.65 6.338-9.01a.75.75 0 0 1 .967.967A8.25 8.25 0 1 0 21.752 15.002z"/></svg>
                        </button>
                        <div class="dropdown dropdown-end dropdown-hover">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar hover:bg-base-200 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-3 shadow-xl bg-base-100 rounded-xl w-64 border border-base-300 backdrop-blur-sm hover:block">
                                <!-- User Info Section -->
                                <li class="mb-2">
                                    <div class="flex items-center gap-3 px-2 py-2 bg-base-200/50 rounded-lg">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-sm text-base-content truncate">
                                                {{ Auth::user()->name ?? 'المدير' }}
                                            </div>
                                            <div class="text-xs text-base-content/60 truncate">
                                                {{ Auth::user()->phone ?? Auth::user()->email ?? 'admin@mouneh.com' }}
                                            </div>
                                        </div>
                                        <div class="w-2 h-2 bg-success rounded-full animate-pulse"></div>
                                    </div>
                                </li>
                                
                                <div class="divider my-2"></div>
                                
                                <!-- Menu Items -->
                                <li>
                                    <a href="/" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-base-200 transition-colors group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        <span class="font-medium">الواجهة الرئيسية</span>
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-base-200 transition-colors group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="font-medium">الملف الشخصي</span>
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-base-200 transition-colors group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="font-medium">الإعدادات</span>
                                    </a>
                                </li>
                                
                                <div class="divider my-2"></div>
                                
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-error/10 text-error transition-colors w-full text-right group">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span class="font-medium">تسجيل الخروج</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="container mx-auto p-6 flex-1 bg-gradient-to-br from-base-100/50 to-base-200/30 min-h-screen">
                @hasSection('breadcrumbs')
                <div class="mb-6 breadcrumbs text-sm bg-base-100/80 backdrop-blur-sm rounded-xl p-4 border border-base-300 shadow-sm">
                    <ul>
                        @yield('breadcrumbs')
                    </ul>
                </div>
                @endif
                <div class="relative">
                @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer footer-center p-6 theme-surface theme-text border-t theme-border bg-gradient-to-r from-base-100 to-base-200/50">
                <aside>
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-2 h-2 bg-success rounded-full animate-pulse"></div>
                        <p>© {{ date('Y') }} <span class="font-semibold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Mouneh</span> — جميع الحقوق محفوظة</p>
                    </div>
                </aside>
            </footer>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <aside class="w-80 min-h-full theme-surface border-l theme-border p-6 bg-gradient-to-b from-base-100 to-base-200/50">
                <div class="flex items-center gap-4 mb-8 px-2">
                    <div class="relative">
                        <img src="{{ asset('images/logo.png') }}" alt="Mouneh" class="h-12 w-auto rounded-xl shadow-lg" />
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-success rounded-full animate-pulse"></div>
                    </div>
                    <div class="leading-none">
                        <div class="font-bold text-lg bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Mouneh</div>
                        <div class="text-xs theme-muted font-medium">Taste the Goodness</div>
                    </div>
                </div>
                <div class="mb-4 px-2">
                    <div class="text-sm font-semibold text-base-content/70 uppercase tracking-wider">القائمة</div>
                    <div class="w-8 h-0.5 bg-gradient-to-r from-primary to-secondary rounded-full mt-1"></div>
                </div>
                <ul class="menu gap-2">
                    <li>
                        <a href="/admin" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="font-medium">الإحصائيات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/users*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <span class="font-medium">المستخدمون</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/admins" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/admins*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="font-medium">المديرون</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/products*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span class="font-medium">المنتجات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/categories" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/categories*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="font-medium">التصنيفات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/brands" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/brands*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h6" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 6V5a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium">العلامات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/orders" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/orders*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="font-medium">الطلبات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/transactions" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/transactions*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">المعاملات المالية</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/invoices" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-base-200 transition-all duration-200 @if(request()->is('admin/invoices*')) bg-primary/10 text-primary border-r-4 border-primary @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="font-medium">الفواتير</span>
                        </a>
                    </li>
                </ul>
            </aside>
        </div>
    </div>

    <style>
    /* Fix dropdown hover behavior */
    .dropdown:hover .dropdown-content {
        display: block !important;
    }
    
    .dropdown-content:hover {
        display: block !important;
    }
    
    /* Ensure dropdown stays open when hovering over any child element */
    .dropdown-content *:hover {
        display: block !important;
    }
    </style>

    <script>
    (function(){
        const html = document.documentElement;
        // Initialize from localStorage
        const saved = localStorage.getItem('theme');
        if (saved === 'dark' || saved === 'mouneh' || saved === 'light') {
            html.setAttribute('data-theme', saved);
        }
        const btn = document.getElementById('themeToggle');
        if (!btn) return;
        btn.addEventListener('click', function(){
            const current = html.getAttribute('data-theme') || 'mouneh';
            const next = current === 'dark' ? 'mouneh' : 'dark';
            html.setAttribute('data-theme', next);
            try { localStorage.setItem('theme', next); } catch (e) {}
        });
    })();
    (function(){
        // Initialize progress bars: set --value based on value/max attributes
        document.querySelectorAll('.progress').forEach(function(el){
            const val = parseFloat(el.getAttribute('value')) || 0;
            const max = parseFloat(el.getAttribute('max')) || 100;
            const pct = Math.max(0, Math.min(100, (val / max) * 100));
            el.style.setProperty('--value', pct + '%');
        });
    })();
    (function(){
        // Swipe gestures to open/close right sidebar (drawer)
        const drawerToggle = document.getElementById('admin-drawer');
        if (!drawerToggle) return;
        let startX = 0, startY = 0, tracking = false;
        const edgeWidth = 24; // px from right edge to start open gesture
        const minDx = 60; // min horizontal distance to trigger
        const maxDy = 40; // cancel if too vertical

        function onTouchStart(e){
            if (!e.touches || !e.touches.length) return;
            const t = e.touches[0];
            startX = t.clientX; startY = t.clientY; tracking = false;
            const vw = window.innerWidth || document.documentElement.clientWidth;
            const fromRight = vw - startX;
            // Start tracking if at right edge (to open) or drawer is open (to allow close swipe)
            if (fromRight <= edgeWidth || drawerToggle.checked) {
                tracking = true;
            }
        }
        function onTouchMove(e){
            // Prevent scroll if a horizontal swipe is underway
            if (!tracking) return;
            const t = e.touches[0];
            const dx = t.clientX - startX; // positive is moving right, negative left
            const dy = Math.abs(t.clientY - startY);
            if (dy > maxDy) { tracking = false; return; }
            // If drawer closed and swiping left-to-right from edge in RTL? We open on small positive dx
            // In RTL right-edge, opening gesture is small leftward move? We'll use absolute distance
            // Decide only at end to avoid jumpiness
        }
        function onTouchEnd(e){
            if (!tracking) return;
            const changed = e.changedTouches && e.changedTouches[0];
            const endX = changed ? changed.clientX : startX;
            const dx = endX - startX; // negative means swipe left
            const dy = 0;
            // RTL: sidebar is on the right. To open: swipe from right edge towards left (dx <= -minDx)
            // To close: when open, swipe towards right (dx >= minDx)
            if (!drawerToggle.checked) {
                if (dx <= -minDx) drawerToggle.checked = true;
            } else {
                if (dx >= minDx) drawerToggle.checked = false;
            }
            tracking = false;
        }
        window.addEventListener('touchstart', onTouchStart, {passive: true});
        window.addEventListener('touchend', onTouchEnd, {passive: true});
    })();
    </script>
    @stack('scripts')
</body>
</html>

