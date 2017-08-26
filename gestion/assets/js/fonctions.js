//utf8 é//
//------------------------------------------------------------------------//
//FONCTIONS GENERIQUES COMMUNES AUX DIFFERENTES PAGES//

//JQUERY //
function ScrollTo(id){
	jQuery('html,body').animate({scrollTop:jQuery(id).offset().top},'1000','swing');
}

function hideOtherLanguage(id)
{
	$('.translatable-field').hide();
	$('.lang-' + id).show();
}

//SUPPRESSION D'ENTRÉE (visuellement + BDD via appel ajax)//
function suppr_entree(_type,_id){
	if(confirm('Supprimer ?')){
		$.ajax({
			type: "GET",
			url: '/gestion/controllers/ajax/api.php',
			async: false,
			cache: false,
			data: 'action=supprime&type='+_type+'&id='+_id,
			success: function(msg){
				//alert(msg);
				$('#'+_id).fadeOut('slow', 
					function(){
						$('#'+_id).remove();
						
						/*!!! recalage fleches ordre !!!*/
						//alert($(".tab-liste tr[id^='']:first").attr('id'));
						if($(".tab-liste tr[id^='']:first .flecheHaut").length>0){
							$(".tab-liste tr[id^='']:first .flecheHaut").remove();
						}
						
						if($(".tab-liste tr[id^='']:last .flecheBas").length>0){
							$(".tab-liste tr[id^='']:last .flecheBas").remove();
						}
					}
				);
                    
                $('#'+_type+'-'+_id).fadeOut('slow', 
					function(){
						$('#'+_type+'-'+_id).remove();
						
						/*!!! recalage fleches ordre !!!*/
						//alert($(".tab-liste tr[id^='']:first").attr('id'));
						if($(".tab-liste tr[id^='']:first .flecheHaut").length>0){
							$(".tab-liste tr[id^='']:first .flecheHaut").remove();
						}
						
						if($(".tab-liste tr[id^='']:last .flecheBas").length>0){
							$(".tab-liste tr[id^='']:last .flecheBas").remove();
						}
					}
				);

			}
		});
	}
}

//Suppression d'une ligne (tr)//
function supprTr(_trId){
	if(confirm('supprimer ?')){
		$('tr#'+_trId).fadeOut("slow", function(){
			var _parent=$(this).parents('table');
			$(this).remove();
			//on supprime tbody vides (firefox)//
			_parent.find('tbody:not(:has(>tr))').remove(); 
		});
	}
}

//selection d'onglet dans les pages d'édition//
function select_onglet(_onglet){
	$('.onglet').hide();
	$('#'+_onglet).show();
	$('#onglets li a').attr('class', '');
	$('#onglet-'+_onglet).attr('class', 'menu-on');
}

//clics sur les boutons de statuts//
function toggleStatut(_entite, _id){
	$.get('edit-'+_entite+'.html',
	{action:'clickStatut', id:_id},
	function(data){
		$('#'+_id+' .btStatut span').attr('class', 'statut'+data);
	});
};

//toggle elements//
function toggle(obj){
	if($('#'+obj).css("display")!="none"){
		$('#'+obj).slideUp("normal");
	}else{
		$('#'+obj).slideDown("normal");
	}
}

//convertit un élément en uploader ajax//
function setUploader(id, callback){
	$('#'+id).makeAsyncUploader({
        upload_url: "/admin/php/ajax/file_upload.php", // Important! This isn't a directory, it's a HANDLER such as an ASP.NET MVC action method, or a PHP file, or a Classic ASP file, or an ASP.NET .ASHX handler. The handler should save the file to disk (or database).
        flash_url: '/admin/assets/swf/swfupload.swf',
        button_image_url: '/admin/assets/img/swfupload/blankButton.png',
		file_size_limit: "6 MB",
		complete:callback
    });
}

function displayOverlay(elem,tWidth){
		$.ajax({
		   type: "POST",
		   url: elem.href,
		   success: function(markup_s){
				$("div#popup_util").html(markup_s);
				if(tWidth==0){
					var oWidth = $('div#popup_util').width();
				}
				else{
					var oWidth = tWidth;
					$('div#popup_util').width(tWidth);
				}
				var oHeight = Math.min($('div#popup_util').height(),$(window).height());
				//Reset pour pas dupliquer éléments/id
				$("div#popup_util").html('');
				
				// alert(markup_s);
				
				//On ajuste pour que ça tienne toujours
				Shadowbox.open({
					content: markup_s,
					player: "html",
					width: oWidth,
					height: oHeight
				});
			}
		});
}

function finishHandler(){
	//Jplayer
	if($("#jquery_jplayer_1").length>0){
		$("#jquery_jplayer_1").jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					m4v: $("#jquery_jplayer_m4v").html(),
					ogv: $("#jquery_jplayer_ogv").html()
				});
			},
			swfPath: "/admin/assets/js/jplayer",
			supplied: "m4v, ogv"
      });
	}
}

//génération d'id unique//
function uniqId (prefix, more_entropy) {
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Kankrelune (http://www.webfaktory.info/)
    // %        note 1: Uses an internal counter (in php_js global) to avoid collision
    // *     example 1: uniqid();    // *     returns 1: 'a30285b160c14'
    // *     example 2: uniqid('foo');
    // *     returns 2: 'fooa30285b1cd361'
    // *     example 3: uniqid('bar', true);
    // *     returns 3: 'bara20285b23dfd1.31879087'
	if (typeof prefix == 'undefined') {
        prefix = "";
    }
 
    var retId;    var formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10).toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
            return seed.slice(seed.length - reqWidth);
        }        if (reqWidth > seed.length) { // so short we pad
            return Array(1 + (reqWidth - seed.length)).join('0') + seed;
        }
        return seed;
    }; 
    // BEGIN REDUNDANT
    if (!this.php_js) {
        this.php_js = {};
    }    // END REDUNDANT
    if (!this.php_js.uniqidSeed) { // init seed with big random int
        this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    this.php_js.uniqidSeed++; 
    retId = prefix; // start with prefix, add current milliseconds hex string
    retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
    retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
    if (more_entropy) {        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10).toFixed(8).toString();
    }
 
    return retId;
}
function add_line(t){
    e = $('#selectjeu').val();
    l = $('#selectjeu option:selected').html();
    var id=t+'_'+e;
    if(e !==''){
        suppr_line(id);
        $('.actu_jeu tbody').prepend('<tr id="'+id+'">\n\
<input type="hidden" value="'+e+'" id="inp_'+id+'" name="tabactujeu[]">\n\
<td>'+l+'</td><td><a onclick="suppr_line(\''+id+'\');return false;" title="Supprimer" class="suppr"></a></td></tr>');
    }
    return false;
}
function suppr_line(id){
    $('#'+id).remove();
    return false;
}
//------------------------------------------------------------------------//