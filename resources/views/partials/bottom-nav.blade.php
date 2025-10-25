<nav class="bottom" aria-label="التنقل السفلي">
  <div class="tabs flex flex-row items-center justify-evenly w-full flex-nowrap overflow-hidden" style="display: flex !important; flex-wrap: nowrap !important;">
    <a class="tab flex-shrink-0 min-w-0 {{ (request()->is('/') || request()->path() === '') ? 'active' : '' }}" href="{{ url('/') }}" style="flex-shrink: 0 !important; white-space: nowrap !important;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg"><path d="M3 10.5 12 3l9 7.5"/><path d="M5.5 9v10.5a1.5 1.5 0 0 0 1.5 1.5h10a1.5 1.5 0 0 0 1.5-1.5V9"/></svg>
      <span style="white-space: nowrap !important;">الرئيسية</span>
    </a>
    <a class="tab flex-shrink-0 min-w-0 {{ request()->is('brands*') ? 'active' : '' }}" href="{{ url('/brands') }}" style="flex-shrink: 0 !important; white-space: nowrap !important;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6Z"/><path d="M8 10h8M8 14h6"/><path d="M7 6V5a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/></svg>
      <span style="white-space: nowrap !important;">العلامات</span>
    </a>
    <a class="tab flex-shrink-0 min-w-0 {{ request()->is('categories*') ? 'active' : '' }}" href="{{ url('/categories') }}" style="flex-shrink: 0 !important; white-space: nowrap !important;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg"><circle cx="6.5" cy="7.5" r="3"/><circle cx="17.5" cy="7.5" r="3"/><circle cx="6.5" cy="17" r="3"/><circle cx="17.5" cy="17" r="3"/></svg>
      <span style="white-space: nowrap !important;">الأقسام</span>
    </a>
    <a class="tab flex-shrink-0 min-w-0 {{ request()->is('cart*') ? 'active' : '' }}" href="{{ url('/cart') }}" style="flex-shrink: 0 !important; white-space: nowrap !important;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg"><path d="M6 6h13l-1.2 9.4a2 2 0 0 1-2 1.8H8.8a2 2 0 0 1-2-1.8L6 6Z"/><path d="M6 6l-.7-2.5H3"/><circle cx="9" cy="20" r="1.5"/><circle cx="16" cy="20" r="1.5"/></svg>
      <span style="white-space: nowrap !important;">السلة</span>
    </a>
    @auth
    @php($unread = auth()->user()->unreadNotifications()->count())
    <a class="tab flex-shrink-0 min-w-0 relative {{ request()->is('notifications*') ? 'active' : '' }}" href="{{ url('/notifications') }}" style="flex-shrink: 0 !important; white-space: nowrap !important;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.172V11a6 6 0 1 0-12 0v3.172a2 2 0 0 1-.6 1.428L4 17h5"/><path d="M9 17v1a3 3 0 0 0 6 0v-1"/></svg>
      <span style="white-space: nowrap !important;">الإشعارات</span>
      @if($unread > 0)
        <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-primary text-white text-[10px] leading-[18px] text-center font-semibold">{{ $unread > 9 ? '9+' : $unread }}</span>
      @endif
    </a>
    @endauth
  </div>
</nav>
