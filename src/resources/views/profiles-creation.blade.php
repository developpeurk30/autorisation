@extends('autorisation::theme.autorisation-theme')
@section('title', 'Administration - Interface de création de Profils')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">
@endsection
@section('content')
    <div class="layout-px-spacing">

        <div class="account-settings-container layout-top-spacing">

            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="form-create-user" method="post" action="{!! route('enregistrer_profil') !!}" enctype="multipart/form-data" class="section general-info">
                                @csrf
                                <div class="info">
                                    <h6 class="">Interface de Création de Profils</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profile_name">Nom du Profil</label>
                                                                    <input type="text" class="form-control mb-4 @error('profile_name') is-invalid @enderror" id="profile_name" name="profile_name" placeholder="Nom du Profil" value="{{ old('profile_name') }}">
                                                                    @error('profile_name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profile_address_redirection">Nom de la Route de Redirection</label>
                                                                    <input id="profile_address_redirection"  name="profile_address_redirection" type="text" class="form-control @error('profile_address_redirection') is-invalid @enderror" placeholder="Nom de la Route de Redirection" value="{{ old('profile_address_redirection') }}">
                                                                    @error('profile_address_redirection')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profile_addr_redirect_link_name">Menu</label>
                                                                    <input type="text" class="form-control mb-4 @error('profile_addr_redirect_link_name') is-invalid @enderror" name="profile_addr_redirect_link_name" id="profile_addr_redirect_link_name" placeholder="Intitulé du Lien" value="{{ old('profile_addr_redirect_link_name') }}">
                                                                    @error('profile_addr_redirect_link_name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-4">
                                                                    <label for="profile_description">Description de Profil</label>
                                                                    <textarea class="form-control @error('profile_description') is-invalid @enderror" id="profile_description" name="profile_description" placeholder="Description du Profil" rows="3">{{ old('profile_description') }}</textarea>
                                                                    @error('profile_description')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6"></div>
                                                            <div class="col-sm-6">
                                                                <div class="n-chk">
                                                                    <div class="form-group">
                                                                        <label class="new-control new-checkbox checkbox-danger">
                                                                            <input type="checkbox" class="new-control-input" name="status">
                                                                            <span class="new-control-indicator"></span>Activer Profil
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="account-settings-footer">
                                    <div class="as-footer-container">
                                        <input id="multiple-reset" class="btn btn-warning" value="Réinitialiser" type="reset">
                                        <div class="blockui-growl-message">
                                            <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                                        </div>
                                        @can('CREATE_PROFILE')
                                        <input type="submit" id="multiple-messages" class="btn btn-primary submit-fn" value="Enregistrer"/>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>


        </div>

    </div>

@endsection
@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
    <script src="{{asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/input-mask/input-mask.js')}}"></script>
    <script>
        $(".profiles").select2({
            tags: true
        });
        $("#phone").inputmask("+999 99-99-99-99");
    </script>
@endsection
