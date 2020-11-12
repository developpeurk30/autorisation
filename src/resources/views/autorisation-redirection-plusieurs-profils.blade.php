@extends('autorisation::theme.autorisation-theme-without-left-menu')
@section('content')
    <div id="content" class="main-content">
        <div class="container">

            <div class="container">
                <div class="row layout-spacing layout-top-spacing" id="cancel-row">
                    <div id="listGroupIcons" class="col-lg-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Menus</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <ul class="list-group list-group-icons-meta">
                                    @foreach($profiles as $profile)
                                    <li class="list-group-item list-group-item-action">
                                        <div class="media">
                                            <div class="d-flex mr-3">

                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="{{ route($profile->profile_address_redirection) }}" >
                                                <h6 class="tx-inverse">{{ $profile->profile_addr_redirect_link_name }}</h6>
                                                </a>
                                                <p class="mg-b-0">{{ $profile->profile_description }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
