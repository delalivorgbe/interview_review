<div class="container col-md-12">

    <h4>Submitted Documents</h4>

    <div class="panel-group">

        @foreach($forms as $form)
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse{{$form->id}}">{{ $form->title }}</a>
                        <span class="pull-right">Deadline: {{$form->expiry_date}} </span>
                    </h4>
                </div>

                <div id="collapse{{$form->id}}" class="panel-collapse collapse">
                    <div class="panel-body">

                        <div class="container col-md-9">
                            <h4><strong>Instructions</strong></h4>
                            <p>{{ $form->description }}</p>

                             <span class="col-md-12">
                                     <hr class="col-md-9"> <br>
                                </span>

                            <h5><strong>Deadline:<span  id="dead{{$form->id}}"> {{ $form->expiry_date }} </span> </strong></h5>
                        </div>

                        <div class="container col-md-3">

                            <div class="row text-center">

                                <span class="fa fa-file-text-o fa-3x"></span> <br/>
                                <span>{{$form->original_filename}}</span>

                                <a href="{{ route('document.delete',['form_id' => $form->id]) }}" class="btn btn-danger col-xs-12">
                                    <span class="glyphicon glyphicon-remove pull-right"></span>
                                    <strong> Delete File</strong>
                                </a>

                                {{--<form method="post" action="#" enctype="multipart/form-data">--}}

                                    {{--<div class="form-group col-xs-12">--}}
                                        {{--<button type="submit" class="btn btn-danger col-xs-12">--}}
                                            {{--<span class="glyphicon glyphicon-remove pull-right"></span>--}}
                                            {{--<strong> Delete File</strong>--}}
                                        {{--</button>--}}
                                        {{--<input type="hidden" value="{{ $form->id }}" name="form_id">--}}
                                        {{--<input type="hidden" value="{{ Session::token() }}" name="_token">--}}
                                    {{--</div>--}}

                                {{--</form>--}}

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        @endforeach


    </div>
</div>