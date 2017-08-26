
$(document).ready(function() {
    $('.tosee').change(function() {
        iso_lang = $(this).val();
        if(iso_lang === 0)
            return false;
        $.ajax({
            type: "GET",
            url: '/gestion/traductions.html',
            async: false,
            data: {
                action: 'getTranslations',
                lang: iso_lang
            },
            success: function(response) {
                $('.translations-forms').fadeOut('200', function() {
                    $(this).html(response).fadeIn('200');
                });
            }
        });
    });
})
