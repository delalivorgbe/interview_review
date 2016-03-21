@extends('layouts.admin_template')

@section('page_title')
    ALU|Document Request
@endsection

@section('css')
    <link href="{{asset('/css/app.css')}}" rel="stylesheet">
@endsection

@section('page_header')
    Document Request
@endsection


@section('menu')
            <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header"></li>
        <li class="active"><a href="{{ url('sdocreq') }}"><i class="fa fa-file-text"></i><span>Document Requests</span></a></li>
        <li><a href="{{ url('forum') }}"><i class="fa fa-comment"></i><span>Forums</span></a></li>
    </ul><!-- /.sidebar-menu -->
@endsection


@section('breadcrumb')

@endsection

@section('content')

    <div class="row">

        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs-up" id="friends">
                <li><a  href="{{ route('students.requests.active') }}" data-target="#contacts" class="media_node active span"
                        id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Active Doc. Requests </a></li>
                <li><a href="{{ url('studsubmitteddocreq') }}" data-target="#friends_list" class="media_node span"
                       id="friends_list_tab" data-toggle="tabajax" rel="tooltip"> Submitted Docs</a></li>
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
                                   required oninvalid="this.setCustomValidity('Please Enter a title')">
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
                                    <option value="pdf">pdf</option>
                                    <option value="png">png</option>
                                    <option value="jpg">jpg</option>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
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














