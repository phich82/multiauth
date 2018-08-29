@if (Auth::guard('web')->check())
    <p>You are logged in as <strong>USER</strong>!</p>
@else
    <p>You are logged out as <strong>USER</strong>!</p>
@endif

@if (Auth::guard('admin')->check())
    <p>You are logged in as <strong>ADMIN</strong>!</p>
@else
    <p>You are logged out as <strong>ADMIN</strong>!</p>
@endif
