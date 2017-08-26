function toggleActivate(_id){
	$('#validate_'+_id)
	$.ajax({
        type: "GET",
        url: '/gestion/personnels.html',
        async: false,
        data: 'action=toggleActive&id='+ _id,
        success: function(msg){
            if($('#validate_'+_id).hasClass('btn-success')){
                $('#validate_'+_id).removeClass('btn-success');
                $('#validate_'+_id).addClass('btn-danger');
                
                $('#validate_'+_id+' > span').removeClass('glyphicon-ok');
                $('#validate_'+_id+' > span').addClass('glyphicon-remove');
            }else{
                $('#validate_'+_id).removeClass('btn-danger');
                $('#validate_'+_id).addClass('btn-success');
                
                $('#validate_'+_id+' > span').removeClass('glyphicon-remove');
                $('#validate_'+_id+' > span').addClass('glyphicon-ok');
            }
        }
    });
}