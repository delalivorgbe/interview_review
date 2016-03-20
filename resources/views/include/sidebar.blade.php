<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->avatar }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name}}</p>
                <a><i class="fa fa-circle text-success"></i>{{ Auth::user()->user_role}}</a>
            </div>
        </div>


        @yield('menu')


    </section>
    <!-- /.sidebar -->
</aside>