@extends('layouts.admin_template')

@section('page_title')
    ALU|Document Request
@endsection

@section('css')
    <link href="{{asset('/css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
@endsection

@section('page_header')
    Document Request
@endsection

@section('menu')
            <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header"></li>
        <!-- Optionally, you can add icons to the links -->
        {{--<li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>--}}
        <li><a href="{{ url('students') }}"><i class="fa fa-users"></i><span>Students</span></a></li>
        <li class="active"><a href="{{ url('forms') }}"><i class="fa fa-file-text"></i><span>Document Request</span></a></li>
        <li><a href="{{ url('forum') }}"><i class="fa fa-comment"></i><span>Forums</span></a></li>
    </ul><!-- /.sidebar-menu -->
@endsection


@section('breadcrumb')
    <div class="new_doc_request_button">
        <button class="btn btn-xs btn-primary" href="#">New Doc Request</button>
    </div>
@endsection

@section('content')

    <div class="row">

        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs-up" id="friends">
                <li><a  href="{{ url('activedocreq') }}" data-target="#contacts" class="media_node active span"
                       id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Active Doc. Requests </a></li>
                <li><a href="{{ url('archiveddocreq') }}" data-target="#friends_list" class="media_node span"
                       id="friends_list_tab" data-toggle="tabajax" rel="tooltip"> Archived Doc. Requests</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="contacts">


                </div>
                <div class="tab-pane" id="friends_list">

                </div>
                <div class="tab-pane  urlbox span8" id="awaiting_request">

                </div>
            </div>

        </div>

    </div>



    <div class="modal fade" tabindex="-1" role="dialog" id="doc-request-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Document Request</h4>
                </div>
                <div class="modal-body">

                    <form action="{{ route('document.request') }}" method="post">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" type="text" name="title" id="title"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="instructions">Instructions</label>
                            <textarea class="form-control" name="instructions" id="instructions" rows="5" cols="1"></textarea>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6" >
                                <label for="expiry-date">Expiry Date</label>
                                <input class="form-control" type="date" name="expiry-date" id="expiry-date">
                            </div>


                            <div class="form-group col-md-6" >
                                <label for="file-format">Fle Format</label>
                                <select class="form-control" name="file-format" id="file-format">
                                    <option value="any">any</option>
                                    <option value="image">image</option>
                                    <option value="pdf">pdf</option>
                                    <option value="doc">doc</option>
                                    <option value="spreadsheet">spreadsheet</option>
                                </select>
                            </div>

                        </div>


                        <div class="form-group">
                            <button type="submit" name="upload" class="btn btn-primary pull-right"> Upload </button>
                            <input type="hidden" value="{{ Session::token() }}" name="_token">
                        </div>

                    </form>


                </div>
                <div class="modal-footer">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->










    <script>
        var token = '{{ Session::token() }}';
        var url = '{{ route('docrequest') }}';
    </script>

@endsection

@section('js')
    <script type="text/javascript">
        setTimeout(function() {
            $("#contacts_tab").trigger('click');
        },10);
    </script>
@endsection














