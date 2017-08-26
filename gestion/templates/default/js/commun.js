function inArray(needle, haystack) {
    for(var i in haystack) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

function getUrlParams( name )
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
		return null;
	else
		return results[1];
}

function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat);
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
}

function checkDelBoxes(pForm, boxName, parent)
{
	for (i = 0; i < pForm.elements.length; i++)
		if (pForm.elements[i].name == boxName)
			pForm.elements[i].checked = parent;
}

function sendBulkAction(form, action)
{
    alert(form);
	String.prototype.splice = function(index, remove, string) {
           
		return (this.slice(0, index) + string + this.slice(index + Math.abs(remove)));
	};

	var form_action = $(form).attr('action');

	if (form_action.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,'').replace(/\s+/g,' ') == '')
		return false;

	if (form_action.indexOf('#') == -1)
		$(form).attr('action', form_action + '?' + action);
	else
		$(form).attr('action', form_action.splice(form_action.lastIndexOf('&'), 0, '?' + action));

	$(form).submit();
}

$(function(){
  
//     $('ul.lang-menu li').on('click', function() {
//		iso_lang = $(this).attr('data-lang');
//		$('.to-translate').hide();
//		$('.lang-' + iso_lang).removeClass('hidden').show();
//	});
	hideOtherLanguage(id_langue);
	// DATE PICKER //
	$.datepicker.setDefaults( $.datepicker.regional[ "" ] );
	
	$('.datepicker').datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat:'yy-mm-dd',
		yearRange: "-5:+5",
		ampm: true
	});
	
    if($('.datetime-picker').length>0){
		$('.datetime-picker').timepicker();
	}

    if($('.year-pick').length>0){
		$('.year-pick').datepicker({dateFormat:'yy'});
	}

	if($('.datepick').length>0){
		$('.datepick').datepicker({ampm: false});
	}
	
/*
	// SORTABLE //
	if($('.sortable').length>0){
		$('.sortable').each(function(){
			$(this).sortable();
		});
	}
	*/
	//SI ONGLETS => SELECTION AUTO DU PREMIER AU DEMARRAGE//
	if($('#onglets li a').length>0){
		var _idFirst=$('#onglets li:first a').attr('id');
		var _param=_idFirst.split('onglet-')[1];
		select_onglet(_param);
	}


	// maj des infos depuis l'intra
	$('a.get-intranet-infos').on('click', majInfosFromIntra);

	$('a.maj-all-from-intranet').on('click', function() {
		$('a.get-intranet-infos').on('click', majInfosFromIntra);
		var $this = $(this);
		$this.addClass('pending');
		$this.removeClass('done');
		productToUpdate = $('a.get-intranet-infos').length;
		setTimeout(majNextProductFromIntra, 10);
		return false;
	});	
	
	$("#filter_reset").on("click",function(){
		url = location.href;
		url = url.split("?");
		url = url[0];
		document.location = url;
	});
	
	$("#check_all_view").on("click", function(event){
		if($(this).is(':checked')){
			$('.check_view').attr('checked', 'true');
		}else
			$('.check_view').removeAttr('checked');
	});
	$("#check_all_add").on("click", function(event){
		if($(this).is(':checked')){
			$('.check_add').attr('checked', 'true');
		}else
			$('.check_add').removeAttr('checked');
	});
	$("#check_all_edit").on("click", function(event){
		if($(this).is(':checked')){
			$('.check_edit').attr('checked', 'true');
		}else
			$('.check_edit').removeAttr('checked');
	});
	$("#check_all_del").on("click", function(event){
		if($(this).is(':checked')){
			$('.check_del').attr('checked', 'true');
		}else
			$('.check_del').removeAttr('checked');
	});
	
	cb_enable = function(current,checkbox_parent){
		$('.cb-disable',checkbox_parent).removeClass('selected');
		current.addClass('selected');
		if(!$('.custom-checkbox',checkbox_parent).is(':checked'))
			$('.custom-checkbox',checkbox_parent).trigger('click');
	}
	cb_disable = function(current,checkbox_parent){
		$('.cb-enable',checkbox_parent).removeClass('selected');
		current.addClass('selected');
		if($('.custom-checkbox',checkbox_parent).is(':checked'))
			$('.custom-checkbox',checkbox_parent).trigger('click');
	}
	$(".cb-enable").on('click',function(){
		var checkbox_parent = $(this).parents('.switch');
		cb_enable($(this),checkbox_parent);
	});
	$(".cb-disable").on('click',function(){
		var checkbox_parent = $(this).parents('.switch');
		cb_disable($(this),checkbox_parent);
	});
	$("input[type=checkbox].custom-checkbox[checked]").each(function(){
		var checkbox_parent = $(this).parents(".switch"); 
		$(".cb-enable",checkbox_parent).addClass("selected"); 
		$(".cb-disable",checkbox_parent).removeClass("selected");    
	});
	
	//$('#images-homeslider').load('edit-medias.html?ftarget=homeslider');
});

var productToUpdate = 0;
function majNextProductFromIntra() {
	productToUpdate --;
	$('a.get-intranet-infos:not(.pending):not(.done):first').click();
}

function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function majInfosFromIntra() {
	var $this = $(this);
	var urlToLoad = $this.attr('href');
	$this.addClass('pending');
	$this.removeClass('done');
	$.ajax({
		type: "GET",
		url : urlToLoad,
		complete : function() {
			$this.removeClass('pending').addClass('done');
			if (productToUpdate > 0) {
				setTimeout(majNextProductFromIntra, 10);
			} else {
				if ($('a.maj-all-from-intranet').length == 0) {
					location.reload();
				}
				$('a.maj-all-from-intranet.pending').removeClass('pending').addClass('done');
			}
		}
	});
	return false;
}

function genericToggleActivate(_id, _url){
	$('#validate_'+_id)
	$.ajax({
        type: "GET",
        url: _url,
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