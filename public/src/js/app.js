$('.new_doc_request_button').find('button').on('click', function(){
    $('#doc-request-modal').modal();
});

$('.edit_doc_request_button').find('a').on('click', function(){
    //$('#edit-doc-request-modal').modal();
    console.log('works');
});

$('#modal-save').on('click', function(){
    $.ajax({
        method: 'POST',
        url: url,
        data: { title: $('#title').val(),
            instructions: $('#instructions').val(),
            expirydate: $('#expiry-date').val(),
            fileformat: $('#file-format').val(),
            _token: token
        }
    })
        .done(function (msg){
            console.log(JSON.stringify(msg));

        });
});


$('.student_file_upload_button').find('button').on('click', function(){
    $('#student-file-upload-modal').modal();
});


$('[data-toggle="tabajax"]').click(function(e) {
    var $this = $(this),
        loadurl = $this.attr('href'),
        targ = $this.attr('data-target');

    $.get(loadurl, function(data) {
        $(targ).html(data);
    });

    $this.tab('show');
    return false;
});



