<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('page_title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->

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

    <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/iCheck/square/blue.css") }}">

    {{--<link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-black.min.css")}}" rel="stylesheet" type="text/css" />--}}

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <![endif]-->
</head>


<body style="background-color: white" class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        {{--<a href="../../index2.html"><b>Admin</b>LTE</a>--}}
        <img src="{{  asset("/src/img/alu_logo_large.png")  }}">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <p class="login-box-msg">We'll only ask you this! We promise.</p>

        <div class="social-auth-links text-center">
            <form method="post" action="{{ route('role.set') }}">

                <div class="form-group">
                    <label for="user-role">I am a...</label>
                    <select name="user-role" id="user-role" class="form-control">
                        <option value="Student">Student</option>
                        <option value="Staff">Staff/Faculty</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="user-role">ALU ID</label>
                    <input class="form-control" type="text" name="alu-id" id="alu-id" placeholder="ALU ID">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-block">Finish</button>
                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                    </select>
                </div>
            </form>
        </div>
        <!-- /.social-auth-links -->


    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
{{--<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>--}}
{{--<!-- Bootstrap 3.3.5 -->--}}
{{--<script src="../../bootstrap/js/bootstrap.min.js"></script>--}}
{{--<!-- iCheck -->--}}
{{--<script src="../../plugins/iCheck/icheck.min.js"></script>--}}

        <!-- jQuery 2.1.3 -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/iCheck/icheck.min.js") }}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
