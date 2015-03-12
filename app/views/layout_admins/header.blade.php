<header class="header">
<a href="{{ url_ex('/') }}" class="logo">Fel Admin</a>
<nav class="navbar navbar-static-top" role="navigation">
<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>

<div class="navbar-right">
<ul class="nav navbar-nav">

<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>{{{ Auth::user()->name }}}<i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header bg-light-blue">
            <img src="{{ imageWithSize(Auth::user()->avatar_url, 100,100) }}" class="img-circle" alt="User Image"/>

            <p>
                {{{ Auth::user()->name }}}
                <small>Member since {{ getFormattedDate(Auth::user()->created_at) }}</small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="col-xs-4 text-center">
                <a href="{{ url_ex('me') }}">Edit</a>
            </div>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="#" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</nav>
</header>
