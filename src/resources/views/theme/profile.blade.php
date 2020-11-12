<div class="user-profile-section">
    <div class="media mx-auto">
        @if(Auth::check())
{{--            <img src="images/{{Auth::user()->photo}}" class="img-fluid mr-2" alt="avatar">--}}
            <img src="{!! asset('images/'.Auth::user()->photo) !!}"class="img-fluid mr-2"  alt="avatar">
        @endif
        <div class="media-body">
            @if(Auth::check())
                <h5>{{Auth::user()->name}}</h5>
                @foreach(Auth::user()->profiles()->wherePivot('profile_user_status',1)->get() as $profile)
                <p>{{$profile->profile_name}}</p>
                @endforeach
            @endif
        </div>
    </div>
</div>
<div class="dropdown-item">
    <a href="{{route('profil_utilisateur')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Mon Profil</span>
    </a>
</div>
<div class="dropdown-item">
    <a href="apps_mailbox.html">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span>My Inbox</span>
    </a>
</div>
<div class="dropdown-item">
    <a href="auth_lockscreen.html">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Lock Screen</span>
    </a>
</div>
<div class="dropdown-item">
    <a href="{{route('logout')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Déconnexion</span>
    </a>
</div>
