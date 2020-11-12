@extends('autorisation::theme.autorisation-theme')
@section('title', 'Administration - Affectation de Permissions aux Profils')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">
@endsection
@section('content')

    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <form id="form-affectation-permissions-profile" method="post"
                              action="{!! route('affecter_permission_a_profil', $profile->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <table id="liste-permissions-profile" class="table table-hover" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th>Description</th>
                                    <th>Module</th>
                                </tr>
                                </thead>
                                @foreach($listePermission as $permission)
                                    <tr>
                                        <td>
                                            <div class="n-chk">
                                                <div class="form-group">
                                                    <label class="new-control new-checkbox checkbox-danger">
                                                        <input type="checkbox" class="new-control-input"
                                                               id="{{$permission->id}}" name="permissions[]"
                                                               value="{{$permission->id}}" @if(in_array($permission->id, $profilePermissions)) {!!   "checked" !!} @endif>
                                                        <span
                                                            class="new-control-indicator"></span>{{$permission->page_code}}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$permission->page_description}}</td>
                                        <td>{{strtoupper($permission->module->module_name)}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Désignation de la Permission</th>
                                        <th>Description de la Permission</th>
                                        <th>Module auquel la Permission est rattachée</th>
                                    </tr>
                                    </tfoot>
                            </table>
                            <div class="account-settings-footer">
                                <div class="as-footer-container">
                                    <input id="multiple-reset" class="btn btn-warning" value="Réinitialiser"
                                           type="reset">
                                    <div class="blockui-growl-message">
                                        <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                                    </div>
                                    @can('PERMISSION_TO_MANAGE_PROFILE')
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
@endsection

@section('js')
    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
    <script>

        $(document).ready(function () {

            var table = $('#liste-permissions-profile').DataTable({
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Affichage Page _PAGE_ sur _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Recherche...",
                    "sLengthMenu": "Résultat :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [1,7, 10, 20, 50],
                "pageLength": 7
            });


            $('#multiple-messages').on( "click", function() {
                // $('#form-affectation-permissions-profile').submit();
                $("#form-affectation-permissions-profile").submit(function(){
                    var data = table.$('input').serialize()+'&_token={!! csrf_token() !!}';
                    $.ajax({
                        type:"POST",data,
                        url:$(this).attr('action'),
                        dataType: 'json',
                        success: function(data){

                            if(data.class == 'success'){
                                {{--location.href = '{!!  route('liste_profile') !!}';--}}
                                location.href = '{!!  route('redirection_vers_liste_profile', $profile->id) !!}';
                            }

                        },
                        error: function(){

                            $("#messageTexte").html('ERREUR : SERVEUR INACCESSIBLE.');
                        }
                    });
                    return false;
                });
            });
        });

    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection
