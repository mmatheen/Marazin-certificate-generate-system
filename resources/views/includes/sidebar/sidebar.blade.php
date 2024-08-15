<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <li class="submenu {{ set_active(['admin-dashboard']) }}">
                    <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin-dashboard') }}" class="{{ set_active(['admin-dashboard']) }}">Admin Dashboard</a></li>
                    </ul>
                </li>

                <li class="menu-title">
                    <span>Management</span>
                </li>

                <li class="submenu {{ set_active(['student']) }}">
                    <a href="#"><i class="feather-grid"></i> <span> Student</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('student') }}" class="{{ set_active(['student']) }}">student</a></li>
                        <li><a href="{{ route('excel-import-page-view') }}" class="{{ set_active(['excel-import-page-view']) }}">Upload students</a></li>
                    </ul>

                </li>

                <li class="submenu {{ set_active(['course']) }}">
                    <a href="#"><i class="feather-grid"></i> <span> Course</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('course') }}" class="{{ set_active(['course']) }}">course</a></li>
                    </ul>
                </li>

                <li class="submenu {{ set_active(['batch']) }}">
                    <a href="#"><i class="feather-grid"></i> <span> Batch</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('batch') }}" class="{{ set_active(['batch']) }}">Batch</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
