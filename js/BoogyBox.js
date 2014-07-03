$(document).ready(function() {
	$('html').click(function() {
		$('#HeadPopUpBox').hide();
		$('#HeadPopUpBox2').hide();
		$('#icon1').attr('class', 'head-icon replaced-svg' );
		$('#icon2').attr('class', 'head-icon replaced-svg' );
	})
	
	$('#HeadPopUp').click(function(e){
		e.stopPropagation();
	});
	
	$('#HeadPopUp2').click(function(e){
		e.stopPropagation();
	});
	
	$('#link').click(function(e) {
		$('#HeadPopUpBox').toggle();
		$('#HeadPopUpBox2').hide();
		if($('#HeadPopUpBox').is(":visible")){
			$('#icon1').attr('class', 'head-icon replaced-svg svg-color-change' );
		}
		else{
			$('#icon1').attr('class', 'head-icon replaced-svg' );
		}
		$('#icon2').attr('class', 'head-icon replaced-svg' );
	});
	
	$('#link2').click(function(e) {
		$('#badge2').hide();
		$('#HeadPopUpBox2').toggle();
		$('#HeadPopUpBox').hide();
		if($('#HeadPopUpBox2').is(":visible")){
			$('#icon2').attr('class', 'head-icon replaced-svg svg-color-change' );
		}
		else{
			$('#icon2').attr('class', 'head-icon replaced-svg' );
		}
		$('#icon1').attr('class', 'head-icon replaced-svg' );
		var value = $('.not_count').length;
		var now = new Date();
		var time = now.getTime();
		time += 3600 * 365 * 24000;
		now.setTime(time);
		document.cookie = 
			'shoppingnotifications=' + value + 
			'; expires=' + now.toUTCString() + 
			'; path=/';
	});
});

/*
 * Replace all SVG images with inline SVG
 */
$('img.head-icon').each(function(i){
    var $img = $(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');
    $.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = $(data).find('svg');

        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if(typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

		$svg = $svg.attr('style', 'padding: 15px 6px; margin: -15px 0px' );
		
        // Replace image with new SVG
        $img.replaceWith($svg);

    }, 'xml');
});