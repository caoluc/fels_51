@include('layout_admins.header')

<div class="wrapper row-offcanvas row-offcanvas-left">
    @include('layout_admins.sidebar')
    <aside class="right-side">
        <section class="content-header">
            <h1>
                {{{ $title }}}
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                @if( $menu === 'dashboard' )
                <i class="fa fa-dashboard"></i>
                <li class="active">{{{ $title }}}</li>
                @else
                <li><a href="{{ url_ex('/') }}"><i class="fa fa-dashboard"></i> {{{ Lang::get('messages.dashboard') }}}</a></li>
                <li class="active">{{{ $title }}}</li>
                @endif
            </ol>
        </section>
        <section class="content">
            @yield('content')
        </section>
    </aside>
</div>

@include('layout_admins.footer')
