jQuery(document).ready(function ($) {
	$('#dm-content input:radio').addClass('input_hidden');
	$('#dm-content label').click(function() {
	    $(this).addClass('selected').siblings().removeClass('selected');
	});
});