<div class="container col-md-12">

    <h4>Active Document Requests</h4>

    <div class="panel-group">

        @foreach($forms as $form)

            @if($form->status == 'ACTIVE')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collaps{{$form->id}}">{{ $form->title }}</a>
                            <span class="pull-right">Recipient Groups: 2014, CS </span>
                        </h4>
                    </div>

                    <div id="collaps{{$form->id}}" class="panel-collapse collapse">
                        <div class="panel-body">

                            <div class="container col-md-9">
                                <h4><strong>Instructions</strong></h4>
                                <p>{{ $form->description }}</p>

                                <h5><strong>Deadline: {{ $form->expiry_date->format('D jS M Y') }}</strong></h5>

                                <h5><strong>Submissions made: 30</strong></h5>

                            </div>

                            <div class="container col-md-3">

                                <div class="row text-center">

                                    @if(Auth::user() == $form->user)
                                        <ul class="horizontal-ul">
                                            <li data-toggle="tooltip" data-placement="top" title="Edit request" class="horizontal-li">
                                                <a href="#"> <i class="fa fa-edit"></i> </a>
                                            </li>

                                            <li data-toggle="tooltip" data-placement="top" title="Archive request" class="horizontal-li">
                                                <a href="{{ route('form.archive',['form_id' => $form->id]) }}"> <i class="fa fa-archive"></i> </a>
                                            </li>

                                            <li data-toggle="tooltip" data-placement="top" title="Delete request" class="horizontal-li">
                                                <a href="{{ route('form.delete',['form_id' => $form->id]) }}"> <i class="fa fa-trash"></i> </a>
                                            </li>
                                        </ul>
                                    @endif

                                </div>


                                <div class="row text-center">
                                    <a href="{{ route('download.archive') }}" class="btn btn-success col-xs-12">
                                        <span class="glyphicon glyphicon-earphone pull-right"></span>
                                        <strong> Download as .zip</strong>
                                    </a>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>

            @endif

        @endforeach

    </div>


</div>