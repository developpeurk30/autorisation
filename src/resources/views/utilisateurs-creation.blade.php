@extends('autorisation::theme.autorisation-theme')
@section('title', 'Administration - Interface de création d\'utilisateurs')
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
                            <form id="form-create-user" method="post" action="{!! route('enregistrer_utilisateur') !!}" enctype="multipart/form-data" class="section general-info">
                                @csrf
                                <div class="info">
                                    <h6 class="">Interface de Création d'Utilisateurs</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <input type="file" id="input-file-max-fs"  name="photo" class="dropify" data-default-file="assets/img/200x200.jpg" data-max-file-size="2M" />
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Charger Photo</p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="name">Nom et Prénoms</label>
                                                                    <input type="text" class="form-control mb-4 @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nom et Prénoms" value="{{ old('name') }}">
                                                                    @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="birth_date">Date de naissance</label>
                                                                    <input id="birth_date"  name="birth_date" type="text" class="form-control @error('birth_date') is-invalid @enderror" placeholder="Date de naissance" value="{{ old('birth_date') }}">
                                                                    @error('birth_date')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="username">Nom Utilisateur</label>
                                                                    <input type="text" class="form-control mb-4 @error('username') is-invalid @enderror" name="username" id="username" placeholder="Nom Utilisateur" value="{{ old('username') }}">
                                                                    @error('username')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                                                                    @error('email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="password">Mot de Passe</label>
                                                                    <input type="password" class="form-control mb-4  @error('password') is-invalid @enderror" name="password" id="password" placeholder="Mot de Passe" value="{{ old('password') }}">
                                                                    @error('password')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="password_confirmation">Confirmation Mot de Passe</label>
                                                                    <input type="password" class="form-control mb-4  @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Confirmation Mot de Passe" value="{{ old('password_confirmation') }}">
                                                                    @error('password_confirmation')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="phone">Téléphone (Ex : +225 08-28-05-55)</label>
                                                                    <input type="text" class="form-control mb-4   @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Téléphone" value="{{ old('phone') }}">
                                                                    @error('phone')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profiles">Profil(s) Utilisateur</label>
                                                                    <select class="form-control tagging profiles   @error('profiles') is-invalid @enderror" multiple="multiple" name="profiles[]" id="profiles">
                                                                        @foreach($listeProfile as $profile)
                                                                            <option value="{{ $profile->id }}">{{$profile->profile_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('profiles')
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
                                                                    <span class="new-control-indicator"></span>Activer Utilisateur
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

{{--                                        <button id="multiple-reset" class="btn btn-warning">Reset All</button>--}}
                                        <input id="multiple-reset" class="btn btn-warning" value="Réinitialiser" type="reset">
                                        <div class="blockui-growl-message">
                                            <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                                        </div>
                                        @can('CREATE_USER')
                                        <input type="submit" id="multiple-messages" class="btn btn-primary submit-fn" value="Enregistrer"/>
                                        @endcan
                                            {{--                    <button id="multiple-messages" class="btn btn-primary" type="submit">Save Changes</button>--}}

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
        $("#birth_date").inputmask("99/99/9999");
        $("#phone").inputmask("+999 99-99-99-99");
    </script>
@endsection
