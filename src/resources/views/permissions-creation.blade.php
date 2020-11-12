@extends('autorisation::theme.autorisation-theme')
@section('title', 'Administration - Interface de création de Permissions')
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
                            <form id="form-create-permission" method="post" action="{!! route('enregistrer_permission') !!}" enctype="multipart/form-data" class="section general-info">
                                @csrf
                                <div class="info">
                                    <h6 class="">Interface de Création de Permissions</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="page_code">Permission(Sans Espace)</label>
                                                                    <input type="text" class="form-control mb-4 @error('page_code') is-invalid @enderror" id="page_code" name="page_code" placeholder="Code de Permission" value="{{ old('page_code') }}">
                                                                    @error('page_code')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="module_id">Module</label>
                                                                    <select class="form-control tagging module_id   @error('module_id') is-invalid @enderror" name="module_id" id="module_id">
                                                                        @foreach($listeModule as $module)
                                                                            <option value="{{ $module->id }}">{{$module->module_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('module_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-4">
                                                                    <label for="page_description">Description</label>
                                                                    <textarea class="form-control @error('page_description') is-invalid @enderror" id="page_description" name="page_description" placeholder="Description de la Permission" rows="3">{{ old('page_description') }}</textarea>
                                                                    @error('page_description')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
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
                                        @can('CREATE_PERMISSION')
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
        $(".module_id").select2({
            tags: true
        });
        $("#phone").inputmask("+999 99-99-99-99");
    </script>
@endsection
