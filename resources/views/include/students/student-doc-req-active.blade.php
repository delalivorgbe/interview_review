<div class="container col-md-12">

    <h4>Document Requests</h4>

    <div class="panel-group">

        @foreach($forms as $form)
            @if($form->status == 'ACTIVE')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse{{$form->id}}">{{ $form->title }}</a>
                            <span class="pull-right">Deadline: {{ $form->expiry_date }} </span>
                        </h4>
                    </div>

                    <div id="collapse{{$form->id}}" class="panel-collapse collapse">
                        <div class="panel-body">

                            <div class="container col-md-9">
                                <h4><strong>Instructions</strong></h4>
                                <p>{{ $form->description }}</p>
                            </div>

                            <div class="container col-md-3">

                                <div class="row text-center">

                                    <form method="post" action="{{ route('document.upload') }}" enctype="multipart/form-data">

                                        <div class="form-group col-xs-12">
                                            <input type="file" name="file_to_upload" id="file_to_upload" required>
                                        </div>

                                        <div class="form-group col-xs-12">
                                            <button type="submit" class="btn btn-success col-xs-12">
                                                <span class="glyphicon glyphicon-upload pull-right"></span>
                                                <strong> Upload File</strong>
                                            </button>
                                            <input type="hidden" value="{{ $form->id }}" name="form_id">
                                            <input type="hidden" value="{{ Session::token() }}" name="_token">
                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            @endif
        @endforeach


    </div>
</div>