$(function() {
    var jcrop_api;
    $('#logo').fileupload({
        /* ... */
        url: './logo.html',
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
                        var img = new Image();
                        $(img).load(function () {
                            $('#image_container').html('');
                            $('#image_container').append(this);					
                        }).attr('src', response)
                          .attr('id', 'target');
                    }else{
                        alert("Une erreur est survenue lors de l'envoi du fichier. \nAssurez vous qu'il s'agisse bien d'une image (jpg ou png) de moins de 2Mo \net ayant une largeur minimale de 360px et une hauteur minimale de 316px")
                    }
                });
            }
     });
  
}); 


