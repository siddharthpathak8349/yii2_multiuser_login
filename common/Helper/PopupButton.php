<?php

namespace common\Helper;

use yii;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class PopupButton extends \yii\bootstrap5\Button
{

    public $formid;
    public $productid;
    public $spinerclass = '"fa fa-spin fa-spinner"';

    /**
     * Auto Run Function
     *
     * @return void
     */
    public function init()
    {

        $view = $this->getView();
        // $id = $this->options['id'];
        $value = $this->options['value'];
        $formid = $this->options['data-id'];
        $js = "
        $('.popupButton').unbind( 'click' ).click( function () {
                $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));

                $('#modal').on('shown.bs.modal', function (e) {
                    var form =jQuery('#{$formid}');
                    form.on('beforeSubmit', function(e) {
                        var submit = form.find(':submit');
                        submit.html('<span class=" . $this->spinerclass . "></span> Processing...');
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
                                    if(data.success === true){
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
        ";

        // $view->registerJs($js);


        return parent::run();
    }
}
