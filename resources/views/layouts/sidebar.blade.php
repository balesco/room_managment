<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" height="42"
                class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">{{ auth()->user()->name }}</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="metismenu side-nav">

        <li class="side-nav-title side-nav-item">Navigation</li>
        @if (auth()->user()->isSuperAdmin())
            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span class="badge badge-info badge-pill float-right">4</span>
                    <span> Dashboards </span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('users.index') }}">Utilisateurs</a>
                    </li>
                    <li>
                        <a href="{{ route('rooms.index') }}">Salles</a>
                    </li>
                    <li>
                        <a href="{{ route('rooms.create') }}">Créer une salle</a>
                    </li>
                    <li>
                        <a href="{{ route('reservations.index') }}">Reservations</a>
                    </li>
                </ul>
            </li>
            <li class="side-nav-title side-nav-item">Apps</li>
        @endif

        <li class="side-nav-item">
            <a href="/" class="side-nav-link">
                <i class="uil-calender"></i>
                <span> Calendar </span>
            </a>
        </li>
    </ul>

    <!-- End Sidebar -->

    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
