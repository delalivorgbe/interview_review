<div class="container col-md-12">

    <h4>@yield('heading')</h4>


    <div class="panel-group">

        @foreach($forms as $form)

                <?php $subs = 0?>

                @foreach($counts as $count)
                    <?php if($form->id == $count->form_id){$subs=$count->num_resps;} ?>
                @endforeach

                 @yield('panel_attr')
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collaps{{$form->id}}">{{ $form->title }}</a>
                            <span class="pull-right"><strong> Submissions made:<?php echo $subs;?> </strong></span>
                        </h4>
                    </div>

                    <div id="collaps{{$form->id}}" class="panel-collapse collapse">
                        <div class="panel-body">

                            <div class="container col-md-9">
                                <h4><strong>Instructions</strong></h4>
                                <p>{{ $form->description }}</p>

                                <h5><strong>Deadline: {{ $form->expiry_date->format('D jS M Y') }}</strong></h5>

                                <h5><strong>Submissions made: <?php echo $subs;?></strong></h5>

                            </div>


                            <div class="container col-md-3">

                                <div class="row text-center">

                                    @if(Auth::user() == $form->user)
                                        <ul class="horizontal-ul">
                                            <li data-toggle="tooltip" data-placement="top" title="Edit request" class="horizontal-li">
                                                <a href="#"> <i class="fa fa-edit"></i> </a>
                                            </li>

                                            @yield('archive_toggle')

                                            <li data-toggle="tooltip" data-placement="top" title="Delete request" class="horizontal-li">
                                                <a href="{{ route('form.delete',['form_id' => $form->id]) }}"> <i class="fa fa-trash"></i> </a>
                                            </li>
                                        </ul>
                                    @endif

                                </div>


                                <div class="row text-center">
                                    <a href="{{ route('download.archive') }}" class="btn btn-success col-xs-12">
                                        <span class="glyphicon glyphicon-download-alt pull-right"></span>
                                        <strong> Download as .zip</strong>
                                    </a>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>


        @endforeach

    </div>


</div>