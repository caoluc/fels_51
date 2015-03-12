<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ imageWithSize(Auth::user()->avatar_url, 100,100) }}" class="img-circle"
                     alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Hi, {{{ Auth::user()->name }}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li @if( $menu == "dashboard" ) class="active" @endif >
                <a href="{{ url_ex('admin') }}">
                    <i class="fa fa-dashboard"></i> <span>{{{ Lang::get('messages.dashboard') }}}</span>
                </a>
            </li>
            <li>
                <a href="{{ url_ex('admin/users') }}">
                    <i class="fa fa-users"></i> {{{ Lang::get('messages.users') }}}
                </a>
            </li>
            <li>
                <a href="{{ url_ex('admin/categories') }}">
                    <i class="fa fa-hand-o-right"></i> {{{ Lang::get('messages.categories') }}}
                </a>
            </li>
            <li>
                <a href="{{ url_ex('admin/words') }}">
                    <i class="fa fa-book fa-fw"></i> {{{ Lang::get('messages.words') }}}
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
