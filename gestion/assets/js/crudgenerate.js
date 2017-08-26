/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $('select#table-name').change(function (e){
        $.ajax({
            type: "POST",
            url: 'crudgenerate.html',
            async: false,
            cache: false,
            data: {tname:$('select#table-name').val()},
            success: function(response){
                $("#table_attribute").html(response);
            },
        });
    });
});