$(document).ready(function () {

//UPLOAD PHOTO
var files;
$('form#upload input[type=file]').on('change', function(event){
    files = this.files;

    event.stopPropagation();
    event.preventDefault();

    if( typeof files == 'undefined' ) return;

    var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });

    data.append( 'my_file_upload', 1 );
    data.append( 'main_photo', 1 );

    $('div#wrapper progress').fadeIn('500');

    $.ajax({
        xhr: function()
	    {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    $('progress').val(percentComplete*100);
                    return false;
                }
            }, false);
		    return xhr;
	    },
        url         : 'upload.php',
        type        : 'POST',
        data        : data,
        cache       : false,
        dataType    : 'html',
        processData : false,
        contentType : false,

        success: function(result){
                if (result.indexOf('status') > 0) {
                    var obj = $.parseJSON(result);

                    $('div.mess').text('');

                    $('div#wrapper progress').fadeOut('500');

                    $('div.preview').html('<img src="upload/' + obj.image + '"><span>обработка</span>');

                     $.ajax({
                            url         : 'merge_img.php',
                            type        : 'POST',
                            data        : 'img='+obj.image,
                            dataType    : 'html',
                            cache: false,
                          success: function(result2){
                                if(result2 == 1) {
                                    $('div.preview').html('<img src="img/result.jpg" />');
                                }
                          }
                     });
                } else {
                    $('div#wrapper progress').hide();
                    $('div.mess').html(result);
                }
        },
        error: function( ){
            console.log( 'Error Ajax');
        }
    });
});

});
