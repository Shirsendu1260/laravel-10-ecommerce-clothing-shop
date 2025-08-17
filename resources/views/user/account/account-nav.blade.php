<ul class="account-nav">
    <li><a href="{{ route('user_dashboard') }}" class="menu-link menu-link_us-s {{ Str::contains(request()->url(), 'dashboard') ? 'menu-link_active' : '' }}">Dashboard</a></li>
    <li><a href="{{ route('user_orders') }}" class="menu-link menu-link_us-s {{ Str::contains(request()->url(), 'orders') ? 'menu-link_active' : '' }}">Orders</a></li>
    <li><a href="{{ route('addresses') }}" class="menu-link menu-link_us-s {{ Str::contains(request()->url(), 'addresses') ? 'menu-link_active' : '' }}">Addresses</a></li>
    <li><a href="{{ route('account_details') }}" class="menu-link menu-link_us-s {{ Str::contains(request()->url(), 'account-details') ? 'menu-link_active' : '' }}">Account Details</a></li>
    <li><a href="{{ route('wishlist') }}" class="menu-link menu-link_us-s {{ Str::contains(request()->url(), 'wishlist') ? 'menu-link_active' : '' }}">Wishlist</a></li>
    <li>
        <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-link menu-link_us-s">
            Logout
        </a>
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</ul>
