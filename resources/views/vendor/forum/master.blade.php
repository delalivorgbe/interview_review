<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('page_title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->

    <title>
        @if (isset($thread))
            {{ $thread->title }} -
        @endif
        @if (isset($category))
            {{ $category->title }} -
        @endif
        {{ trans('forum::general.home_title') }}
    </title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    @yield('css')

    {{--<link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />--}}
            <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-black.min.css")}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

    <style>

        textarea {
            min-height: 200px;
        }

        .deleted {
            opacity: 0.65;
        }
    </style>

</head>

{{--<body class="skin-black sidebar-collapse sidebar-mini" >--}}

<body class="skin-black row-offcanvas skin-black sidebar-collapse sidebar-mini" >
<div class="wrapper">

    <!-- Header -->
    @include('include.lte_header')

            <!-- Sidebar -->
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

            @if(Auth::user()->user_role == 'Staff')
                <ul class="sidebar-menu">
                    <li class="header"></li>
                    <!-- Optionally, you can add icons to the links -->
                    <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
                    <li><a href="{{ url('students') }}"><i class="fa fa-users"></i><span>Students</span></a></li>
                    <li><a href="{{ url('forms') }}"><i class="fa fa-file-text"></i><span>Document Request</span></a></li>
                    <li class="active"><a href="{{ url('forum') }}"><i class="fa fa-comment"></i><span>Forums</span></a></li>
                </ul><!-- /.sidebar-menu -->
            @endif

            @if(Auth::user()->user_role == 'Student')
                <ul class="sidebar-menu">
                    <li class="header"></li>
                    <li><a href="{{ url('sdocreq') }}"><i class="fa fa-file-text"></i><span>Document Requests</span></a></li>
                    <li class="active"><a href="{{ url('forum') }}"><i class="fa fa-comment"></i><span>Forums</span></a></li>
                </ul><!-- /.sidebar-menu -->
            @endif

        </section>
        <!-- /.sidebar -->
    </aside>

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="container">
            @include ('forum::partials.breadcrumbs')
            @include ('forum::partials.alerts')

            @yield('content')
        </div>

    </div><!-- /.content-wrapper -->


            <!-- Footer -->.
    @include('include.footer')

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.3 -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>

<script src="{{ URL::to('src/js/app.js') }}"></script>


<script>
    var toggle = $('input[type=checkbox][data-toggle-all]');
    var checkboxes = $('table tbody input[type=checkbox]');
    var actions = $('[data-actions]');
    var forms = $('[data-actions-form]');
    var confirmString = "{{ trans('forum::general.generic_confirm') }}";

    function setToggleStates() {
        checkboxes.prop('checked', toggle.is(':checked')).change();
    }

    function setSelectionStates() {
        checkboxes.each(function() {
            var tr = $(this).parents('tr');

            $(this).is(':checked') ? tr.addClass('active') : tr.removeClass('active');

            checkboxes.filter(':checked').length ? $('[data-bulk-actions]').removeClass('hidden') : $('[data-bulk-actions]').addClass('hidden');
        });
    }

    function setActionStates() {
        forms.each(function() {
            var form = $(this);
            var method = form.find('input[name=_method]');
            var selected = form.find('select[name=action] option:selected');
            var depends = form.find('[data-depends]');

            selected.each(function() {
                if ($(this).attr('data-method')) {
                    method.val($(this).data('method'));
                } else {
                    method.val('patch');
                }
            });

            depends.each(function() {
                (selected.val() == $(this).data('depends')) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
            });
        });
    }

    setToggleStates();
    setSelectionStates();
    setActionStates();

    toggle.click(setToggleStates);
    checkboxes.change(setSelectionStates);
    actions.change(setActionStates);

    forms.submit(function() {
        var action = $(this).find('[data-actions]').find(':selected');

        if (action.is('[data-confirm]')) {
            return confirm(confirmString);
        }

        return true;
    });

    $('form[data-confirm]').submit(function() {
        return confirm(confirmString);
    });
</script>

@yield('js')
@yield('footer')
</body>
</html>





