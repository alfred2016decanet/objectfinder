//init colorpicker
$('#colorpickerHolder2').ColorPicker({
	flat: true,
	onSubmit: function(hsb, hex, rgb) {
		$('#colorSelector2 div').css('backgroundColor', '#' + hex);
		$('#form_habillage_couleur').val(hex);
		$('#colorpickerHolder2').stop().animate({height: widt ? 0 : 173}, 500);
		widt = !widt;
	}
});
$('#colorpickerHolder2>div').css('position', 'absolute');
var widt = false;
$('#colorSelector2').bind('click', function() {
	$('#colorpickerHolder2').stop().animate({height: widt ? 0 : 173}, 500);
	widt = !widt;
});