@extends('layouts.admin_template')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
@endsection

@section('page_title')
    ALU|Students
@endsection

@section('page_header')
    Students
@endsection

@section('breadcrumb')
    <div class="student_file_upload_button">
        <button class="btn btn-xs btn-primary">Upload File</button>
    </div>
@endsection

@section('menu')
            <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header"></li>
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
        <li class="active"><a href="{{ url('students') }}"><i class="fa fa-users"></i><span>Students</span></a></li>
        <li><a href="{{ url('forms') }}"><i class="fa fa-file-text"></i><span>Document Request</span></a></li>
        <li><a href="{{ url('forum') }}"><i class="fa fa-comment"></i><span>Forums</span></a></li>
    </ul><!-- /.sidebar-menu -->
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header">

                </div><!-- /.box-header -->
                <div class="box-body">


                    <table id="student_table" class="table table-striped table-sm">
                        <thead class="thead-default">
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Class</th>
                            <th>Major</th>
                            <th>Nationality</th>
                            <th>Gender</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($students as $student)

                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $student->first_name  }}</td>
                                <td>{{ $student->last_name  }}</td>
                                <td>{{ $student->class  }}</td>
                                <td>{{ $student->major  }}</td>
                                <td>{{ $student->country  }}</td>
                                <td>{{ $student->gender  }}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>


                </div>
            </div>



        </div>
    </div>

@endsection


<div class="modal fade" tabindex="-1" role="dialog" id="student-file-upload-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Student Data</h4>
            </div>
            <div class="modal-body">

                <form action="{{ route('file.upload') }}" method="post" enctype="multipart/form-data">

                    <div  class="form-group">
                        <label for="file_to_upload"></label>
                        <input class="form-control" type="file" name="file_to_upload" id="file_to_upload" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="upload" class="btn btn-primary pull-right"> Upload </button>
                        <input type="hidden" value="{{ Session::token() }}" name="_token">
                    </div>

                </form>



            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@section('js')
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {
            $('#student_table').dataTable({
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false
            });
        });
    </script>
@endsection

