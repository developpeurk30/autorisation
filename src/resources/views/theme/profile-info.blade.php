<figure class="user-cover-image"></figure>
<div class="user-info">
    @if(Auth::check())
{{--        <img src="images/{{Auth::user()->photo}}" alt="avatar">--}}
        <img src="{!! asset('images/'.Auth::user()->photo) !!}" alt="avatar">
    @endif
    @if(Auth::check())
        <h6>{{Auth::user()->name}}</h6>
        @foreach(Auth::user()->profiles()->wherePivot('profile_user_status',1)->get() as $profile)
            {{$profile->profile_name}}<br>
        @endforeach
    @endif
</div>
