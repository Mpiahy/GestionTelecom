<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    {{-- <link rel="icon" href="https://www.colas.com/favicon-32x32.png?v=a3aaafc2f61dca56c11ff88452088fe0" type="image/png"> --}}
    <link rel="stylesheet" href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/Nunito.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/fonts/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/animate.min.css')}}">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="color: var(--bs-accordion-active-color);background: rgb(10,72,102);">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="/index.html">
                    <div>
                        <img src="{{asset('/assets/img/COLAS.png')}}" width="201" height="63">
                    </div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item">
                        <a class="nav-link active" data-bss-hover-animate="pulse" href="/index.html">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tableau de Bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bss-hover-animate="pulse" href="/profil.html">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bss-hover-animate="pulse" aria-expanded="true" data-bs-toggle="dropdown" href="/blank.html">
                            <i class="fas fa-database"></i>
                            <span>Référentiels</span>
                        </a>
                        <div class="dropdown-menu" style="background: #0a4866;border-style: none;border-color: #0a4866;margin-right: 9px;padding-top: 0px;" data-bs-smooth-scroll="true">
                            <a data-bss-hover-animate="pulse" class="nav-link" href="/ref_employe.html" style="padding-left: 35px;padding-top: 0px;padding-bottom: 15px;">
                                <i class="fas fa-users"></i>
                                <span>Employés</span>
                            </a>
                            <a data-bss-hover-animate="pulse" class="nav-link" href="/ref_chantier.html" style="padding-left: 35px;padding-top: 0px;padding-bottom: 15px;">
                                <i class="far fa-building" style="font-size: 14px;"></i>
                                <span>Chantiers</span>
                            </a>
                            <a data-bss-hover-animate="pulse" class="nav-link" href="/ref_operateur.html" style="padding-left: 35px;padding-top: 0px;padding-bottom: 15px;">
                                <i class="fas fa-globe"></i>
                                <span>Opérateurs</span>
                            </a>
                            <a data-bss-hover-animate="pulse" class="nav-link" href="/ref_ligne_mobile.html" style="padding-left: 35px;padding-top: 0px;padding-bottom: 15px;">
                                <i class="fas fa-phone-alt"></i>
                                <span>Lignes mobiles</span>
                            </a>
                            <a data-bss-hover-animate="pulse" class="nav-link" href="/ref_ligne_fixe.html" style="padding-left: 35px;padding-top: 0px;padding-bottom: 15px;">
                                <i class="fas fa-broadcast-tower"></i>
                                <span>Lignes fixes</span>
                            </a>
                            <a data-bss-hover-animate="pulse" class="nav-link" href="/ref_telephone.html" style="padding-left: 35px;padding-top: 0px;padding-bottom: 15px;">
                                <i class="fas fa-tablet-alt"></i>
                                <span>Téléphones</span>
                            </a>
                            <a data-bss-hover-animate="pulse" class="nav-link" href="/ref_box.html" style="padding-left: 35px;padding-top: 0px;padding-bottom: 15px;">
                                <i class="fas fa-wifi"></i>
                                <span>Box Internet</span>
                            </a>
                            <a data-bss-hover-animate="pulse" class="nav-link" href="#" style="padding-left: 35px;padding-top: 0px;padding-bottom: 10px;">
                                <i class="fas fa-money-check-alt"></i>
                                <span>Offres et forfaits</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand shadow mb-4 topbar static-top" style="background: #0a4866;">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                            <div>
                                <span style="font-size: 30px;font-weight: bold;font-family: Nunito, sans-serif;color: #fff200;">TELECOM-MADA</span>
                            </div>
                        </a>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" data-bss-hover-animate="pulse" href="#">
                                        @if (Auth::check())
                                        <span class="d-none d-lg-inline me-2 text-600 small" style="font-size: 18px;padding-right: 10px;">
                                            {{ $login }}
                                        </span>
                                        @else
                                            <span class="d-none d-lg-inline me-2 text-600 small" style="font-size: 18px;padding-right: 10px;">
                                                Invité
                                            </span>
                                        @endif
                                        <img class="border rounded-circle img-profile" src="/assets/img/avatars/User.png" width="32" height="32"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <a class="dropdown-item" data-bss-hover-animate="pulse" href="#">
                                            <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profil
                                        </a>
                                        <a class="dropdown-item" data-bss-hover-animate="pulse" href="#">
                                            <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Paramètres
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" data-bss-hover-animate="pulse" href="{{ url('/logout') }}">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Se déconnecter
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                {{-- <!-- Contenu des pages index --> --}}
                @yield('content_index')

            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © TELECOM-MADA 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="{{asset('/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/js/chart.min.js')}}"></script>
    <script src="{{asset('/assets/js/bs-init.js')}}"></script>
    <script src="{{asset('/assets/js/theme.js')}}"></script>
</body>

</html>