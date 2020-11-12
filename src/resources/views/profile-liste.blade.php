@extends('autorisation::theme.autorisation-theme')
@section('title', 'Administration - Liste des utilisateurs')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
@endsection
@section('content')

    <div class="layout-px-spacing">
        @include('autorisation::messages.flash')
        <div class="row layout-top-spacing" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        @can('VIEW_PROFILE')
                        <table id="liste-profile" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Profil</th>
                                <th>Nom de Route(Adresse Redirection)</th>
                                <th>Menu</th>
                                <th>Description</th>
                                <th>Statut</th>
                                <th class="no-content"></th>
                            </tr>
                            </thead>
                            @foreach($listeProfile as $profile)
                                <tr>
                                    <td>{{$profile->profile_name}}</td>
                                    <td>{{$profile->profile_address_redirection}}</td>
                                    <td>{{$profile->profile_addr_redirect_link_name}}</td>
                                    <td>{{$profile->profile_description}}</td>
                                    <td>{{($profile->profile_status ==1)?'ACTIF': 'INACTIF'}}</td>
                                    <td>
                                        <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                                @can('EDIT_PROFILE')
                                                <a href="{{route('modification_profil_par_admin',$profile->id)}}" class="btn btn-warning" title="Modification du Profil"><i class="fas fa-user-cog"></i></a>
                                                @endcan
                                                @can('PERMISSION_TO_MANAGE_PROFILE')
                                                <a href="{{route('affectation_permission_a_profil',$profile->id)}}" class="btn btn-danger" title="Gestion des Droits du Profil"><i class="fas fa-lock"></i></a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Nom de Profil</th>
                                    <th>Adresse de Redirection Après Authentification</th>
                                    <th>Intitulé du Lien</th>
                                    <th>Description du Profil</th>
                                    <th>Statut du Profil</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                        </table>
                        @endcan
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{--    </div>--}}
@endsection

@section('js')
    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
    <script>
        $('#liste-profile').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Affichage Page _PAGE_ sur _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Recherche...",
                "sLengthMenu": "Résultat :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection
