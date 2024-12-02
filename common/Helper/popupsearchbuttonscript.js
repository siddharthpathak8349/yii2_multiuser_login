$('.popupSearchButton').unbind( 'click' ).click( function () {
    $('#modal').modal('show')
    .find('#modalContent')
    .load($(this).attr('value'));
    
    var formid = $(this).attr("data-id");
    var searchformid = $(this).attr("data-searchid");

    $('#modal').on('shown.bs.modal', function (e) {
        var form =jQuery('#'+formid);
        form.on('beforeSubmit', function(e) {
            var submit = form.find(':submit');
            submit.html('<span class="fa fa-spin fa-spinner"></span> Processing...');
            submit.prop('disabled', true);
            e.preventDefault();
            jQuery.ajax({
                url: form.attr('action'),
                    type: form.attr('method'),
                    data: new FormData(form[0]),
                    mimeType: 'multipart/form-data',
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.success === true) {
                            $('#'+searchformid).submit();
                            $('#modal').modal('hide');
                        }
                    },
                    error  : function (e)
                    {
                        console.log(e);
                    }   
            });
            return false;        
        })
        $('#modal form')[0].reset();
        
    });
});