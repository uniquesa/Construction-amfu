<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
        Notifications ({{ auth()->user()->unreadNotifications->count() }})
    </a>
    <ul class="dropdown-menu">
        @foreach(auth()->user()->unreadNotifications as $notification)
            <li>
                <a class="dropdown-item" href="{{ url('/requests/'.$notification->data['request_id']) }}">
                    {{ $notification->data['message'] }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
