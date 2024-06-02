<div class="left-side-menu">

    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="menu-title"><img src="{{ url(@$setting->logo_1) }}" height="100" width="100"></li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('setting.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Setting </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('department.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Department </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('latestnews.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Latest News </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('goals.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Our Goals </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('team.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Team </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('service.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Service </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('casestudy.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Case Study </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('pricing.show') }}">
                        <i data-feather="message-square"></i>
                        <span> Pricing </span>
                    </a>
                </li>








            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>