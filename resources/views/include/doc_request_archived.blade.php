<div class="container col-md-12">

    <h4>Archived Document Requests</h4>

    <div class="panel-group">

        @foreach($forms as $form)

            @if($form->status == 'ARCHIVED')

                <?php $subs = 0?>

                @foreach($counts as $count)
                    <?php if($form->id == $count->form_id){$subs=$count->num_resps;} ?>
                @endforeach

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collaps{{$form->id}}">{{ $form->title }}</a>
                            <span class="pull-right">Submissions made: <?php echo $subs?> </span>
                        </h4>
                    </div>

                    <div id="collaps{{$form->id}}" class="panel-collapse collapse">
                        <div class="panel-body">

                            <div class="container col-md-9">
                                <h4><strong>Instructions</strong></h4>
                                <p>{{ $form->description }}</p>

                                 <span class="col-md-12">
                                     <hr class="col-md-9"> <br>
                                </span>

                                <h5><strong>Deadline: {{ $form->expiry_date->format('D jS M Y') }}</strong></h5>

                                <h5><strong>Submissions made: <?php echo $subs?></strong></h5>

                            </div>

                            <div class="container col-md-3">

                                <div class="row text-center">

                                    @if(Auth::user() == $form->user)
                                        <ul class="horizontal-ul">

                                            <li data-toggle="tooltip" data-placement="top" title="View Submissions" class="horizontal-li">
                                                <a href="#"> <i class="fa fa-list"></i> </a>
                                            </li>

                                            <li data-toggle="tooltip" data-placement="top" title="Edit request" class="horizontal-li">
                                                <a href="#"> <i class="fa fa-edit"></i> </a>
                                            </li>

                                            <li data-toggle="tooltip" data-placement="top" title="Unarchive request" class="horizontal-li">
                                                <a href="{{ route('form.unarchive',['form_id' => $form->id]) }}"> <i class="fa fa-archive"></i> </a>
                                            </li>

                                            <li data-toggle="tooltip" data-placement="top" title="Delete request" class="horizontal-li">
                                                <a href="{{ route('form.delete',['form_id' => $form->id]) }}"> <i class="fa fa-trash"></i> </a>
                                            </li>
                                        </ul>
                                    @endif

                                </div>


                                <div class="row text-center">
                                    <a @if($subs != 0)
                                       href="{{ route('download.archive') }}"
                                       @else
                                       data-toggle="tooltip" data-placement="bottom" title="Nothing to download"
                                       @endif

                                       class="btn btn-success col-xs-12">
                                        <span class="glyphicon glyphicon-download-alt pull-right"></span>
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