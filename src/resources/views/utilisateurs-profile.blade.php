@extends('autorisation::theme.autorisation-theme')
@section('title', 'Profil utilisateur')
@section('css')
    <link href="{!! asset('assets/css/users/user-profile.css') !!}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{!! asset('plugins/select2/select2.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/forms/theme-checkbox-radio.css') !!}">
@endsection
@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-spacing">

            <!-- Content -->
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between">
                            <h3 class="">Info</h3>
                            <a class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                        </div>
                        <div class="text-center">
                            <img src="images/{{Auth::user()->photo}}" alt="avatar" style="width: 150px; height: 150px;">
                            <div class="user-info">
                                <p class="">{{Auth::user()->name}}</p>
                            </div>
                        </div>
                        <div class="user-info-list">

                            <div class="">
                                <ul class="contacts-block list-unstyled">

                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>{{\Carbon\Carbon::parse(Auth::user()->birth_date)->format('d/m/Y')}}
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg> {{Auth::user()->username}}
                                    </li>
                                    <li class="contacts-block__item">
                                        <a href="mailto:example@mail.com"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>{{Auth::user()->email}}</a>
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> {{Auth::user()->phone}}
                                    </li>
                                    <li class="contacts-block__item">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <div class="social-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                                </div>
                                            </li>
                                            <li class="list-inline-item">
                                                <div class="social-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                                                </div>
                                            </li>
                                            <li class="list-inline-item">
                                                <div class="social-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">
                @include('autorisation::messages.flash')
                <div class="skills layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <h3 class="">Changer Photo de Profil</h3>
                        <div class="row">
                            <form id="form-user-photo" method="post" action="{!! route('changer_photo_profil_utilisateur') !!}" enctype="multipart/form-data" class="general-info">
                                @csrf
                                <div class="info">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                        <div class="upload mt-12 pr-md-12">
                                            <input type="file" id="input-file-max-fs"  name="photo" class="dropify" data-default-file="assets/img/200x200.jpg" data-max-file-size="2M" />
                                            <p class="mt-12"><i class="flaticon-cloud-upload mr-12"></i> Charger Photo</p>
                                        </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="skills layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <h3 class="">Modifier Mot de Passe</h3>
                        <div class="row">
                            <form id="form-user-password" method="post" action="{!! route('utilisateur_change_mot_de_passe') !!}" enctype="multipart/form-data" class="general-info">
                                @csrf
                                <div class="info">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="old_password">Mot de Passe Actuel</label>
                                                <input type="password" class="form-control mb-4  @error('old_password') is-invalid @enderror" name="old_password" id="old_password" placeholder="Mot de Passe Actuel" value="{{ old('old_password') }}">
                                                @error('old_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="password">Nouveau Mot de Passe</label>
                                                <input type="password" class="form-control mb-4  @error('password') is-invalid @enderror" name="password" id="password" placeholder="Nouveau Mot de Passe" value="{{ old('password') }}">
                                                @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirmation Mot de Passe</label>
                                                <input type="password" class="form-control mb-4  @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Confirmation Nouveau Mot de Passe" value="{{ old('password_confirmation') }}">
                                                @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <input id="annuler_password" class="btn btn-warning" value="Réinitialiser" type="reset">
                                    <input type="submit" id="valider_password" class="btn btn-primary submit-fn" value="Modifier Mot de Passe"/>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="skills layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <h3 class="">Autres Modifications</h3>
                        <div class="row">
                            <form id="form-user-password" method="post" action="{!! route('modifier_info_utilisateur') !!}" enctype="multipart/form-data" class="general-info">
                                @csrf
                                <div class="info">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Nom et Prénoms</label>
                                                <input type="text" class="form-control mb-4 @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nom et Prénoms" value="{{Auth::user()->name}}">
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="birth_date">Date de naissance</label>
                                                <input id="birth_date"  name="birth_date" type="text" class="form-control @error('birth_date') is-invalid @enderror" placeholder="Date de naissance" value="{{ \Carbon\Carbon::parse(Auth::user()->birth_date)->format('d/m/Y')}}">
                                                @error('birth_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="phone">Téléphone (Ex : +225 08-28-05-55)</label>
                                                <input type="text" class="form-control mb-4   @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Téléphone" value="{{Auth::user()->phone}}">
                                                @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="profiles">Profil(s) Utilisateur</label>
                                                <select class="form-control tagging profiles   @error('profiles') is-invalid @enderror" multiple="multiple" name="profiles[]" id="profiles" disabled="disabled">
                                                    @foreach($listeProfile as $profile)
                                                        <option value="{{ $profile->id }}" selected>{{$profile->profile_name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('profiles')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <input id="annuler_info" class="btn btn-warning" value="Réinitialiser" type="reset">
                                    <input type="submit" id="valider_info" class="btn btn-primary submit-fn" value="Enregistrer"/>
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
    <script src="plugins/select2/select2.min.js"></script>
    <script src="plugins/select2/custom-select2.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.bundle.min.js"></script>
    <script src="plugins/input-mask/input-mask.js"></script>
    <script>
        $("#input-file-max-fs").on("change", function(){
            $("#form-user-photo").submit();
        });
        $(".profiles").select2({
            tags: true
        });
        $("#birth_date").inputmask("99/99/9999");
        $("#phone").inputmask("+999 99-99-99-99");
    </script>
@endsection
