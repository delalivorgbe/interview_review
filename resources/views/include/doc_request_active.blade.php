<div class="container col-md-12">

    <h4>Active Document Requests</h4>


    <div class="panel-group">

        @foreach($forms as $form)

            @if($form->status == 'ACTIVE')

                <?php $subs = 0?>

                 @foreach($counts as $count)
                        <?php if($form->id == $count->form_id){$subs=$count->num_resps;} ?>
                 @endforeach

                <div class="panel panel-default">
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


                                <span class="col-md-12">
                                     <hr class="col-md-9"> <br>
                                </span>



                                <h5><strong>Deadline: {{ $form->expiry_date->format('D jS M Y') }}</strong></h5>

                                <h5><strong>Submissions made: <?php echo $subs;?></strong></h5>

                            </div>


                            <div class="container col-md-3">

                                <div class="row text-center">

                                    @if(Auth::user() == $form->user)
                                        <ul class="horizontal-ul">

                                            <li data-toggle="tooltip" data-placement="top" title="View Submissions" class="horizontal-li">
                                                <a href="#"> <i class="fa fa-list"></i> </a>
                                            </li>


                                            <li data-toggle="tooltip" data-placement="top" title="Edit Request" class="horizontal-li">
                                                <span class="edit_doc_request_button">
                                                    <a data-toggle='modal'  href="#edit-doc-request-modal"
                                                       data-form-id="{{$form->id}}"
                                                       data-instruction="{{$form->description}}"
                                                       data-title="{{$form->title}}"
                                                       data-date="{{$form->expiry_date}}"
                                                       data-format="{{$form->format}}" >
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </span>
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


<div class="modal fade" tabindex="-1" role="dialog" id="edit-doc-request-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Document Request</h4>
            </div>
            <div class="modal-body">

                <form action="#" method="post">
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
                                <option value="pdf">pdf</option>
                                <option value="png">png</option>
                                <option value="jpg">jpg</option>
                            </select>
                        </div>

                    </div>


                    <div class="form-group">
                        <input type="hidden" id="form-id" name="form-id">
                        <input type="hidden" value="{{ Session::token() }}" name="_token">
                    </div>

                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save" >Save changes</button>
                </div>


            </div>
            <div class="modal-footer">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{--<script  type="text/javascript">--}}
    {{--$('.edit_doc_request_button').find('.edit').on('click', function(event){--}}

        {{--event.preventDefault();--}}

        {{--var reqTitle = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.--}}
                {{--parentNode.parentNode.childNodes[1].childNodes[0].nextElementSibling.nextElementSibling.textContent;--}}

        {{--console.log(reqTitle);--}}


        {{--$('#edit-doc-request-modal').modal();--}}
    {{--});--}}
{{--</script>ent--}}


<script type="text/javascript">
    $('#edit-doc-request-modal').on('show.bs.modal', function (event) {
        var formId = $(event.relatedTarget).data('form-id');
        $(event.currentTarget).find('input[name="form-id"]').val(formId);

        var title = $(event.relatedTarget).data('title');
        $(event.currentTarget).find('input[name="title"]').val(title);

        var instruction = $(event.relatedTarget).data('instruction');
        $(event.currentTarget).find('textarea[name="instructions"]').val(instruction);

        var deadline = $(event.relatedTarget).data('date');
        $(event.currentTarget).find('input[name="expiry-date"]').val(deadline);

        var format = $(event.relatedTarget).data('format');
        $("#file-format").val(format);
    });
</script>


<script type="text/javascript">
    $('#modal-save').on('click', function(){
        $.ajax({
            method: 'POST',
            url: url,
            data: { title: $('#title').val(),
                instructions: $('#instructions').val(),
                expirydate: $('#expiry-date').val(),
                fileformat: $('#file-format').val(),
                formId: $('#form-id').val(),
                _token: token
            }
        })
          .done(function (msg){
              console.log(msg['message']);
          });
    });
</script>

<script>
    var token = '{{ Session::token() }}';
    var url = '{{ route('edit') }}';
</script>


