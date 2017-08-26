$(function() {
    var jcrop_api;
    $('#photo').fileupload({
        /* ... */
        url: './edit-personnel.html',
        sequentialUploads: true,
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );

        },

        add: function (e, data) {
            var jqXHR = data.submit()
                .done(function (result, textStatus, jqXHR) { /*...*/ })
                .fail(function (jqXHR, textStatus, errorThrown) {/*...*/})
                .always(function (response) {
                    if(response != "error"){
                        $("#img-thumbnail").attr('src', response);
                        $("#form_photo").val(response);
                    }else{
                        alert("Une erreur est survenue lors de l'envoi du fichier. \nAssurez vous qu'il s'agisse bien d'une image (jpg ou png) de moins de 2Mo \net ayant une largeur minimale de 360px et une hauteur minimale de 316px")
                    }
                });
            }
     });
  
}); 


