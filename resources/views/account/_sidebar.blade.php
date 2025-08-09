<div class="list-group list-group-flush">
    <a href="{{ route('account.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.index') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.profile') ? 'active' : '' }}">Profile</a>
    <a href="{{ route('account.security') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.security') ? 'active' : '' }}">Security</a>
    <a href="{{ route('account.notifications') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.notifications') ? 'active' : '' }}">Notifications</a>
    <a href="{{ route('account.connections') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.connections') ? 'active' : '' }}">Connected Accounts</a>
    <a href="{{ route('account.api_keys') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.api_keys') ? 'active' : '' }}">API Keys</a>
    <a href="{{ route('account.billing') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.billing') ? 'active' : '' }}">Billing</a>
    <a href="{{ route('account.support') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.support') ? 'active' : '' }}">Support</a>
</div> 