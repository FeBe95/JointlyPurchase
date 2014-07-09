$(document).ready(function() {
	$('html').click(function() {
		$('#HeadPopUpBox1').hide();
		$('#HeadPopUpBox2').hide();
		$('#HeadPopUpBox3').hide();
		$('#friendrequests').attr('class','icon');
		$('#messages').attr('class','icon');
		$('#notifications').attr('class','icon');
	})
	
	$('#HeadPopUp1').click(function(e){
		e.stopPropagation();
	});
	
	$('#HeadPopUp2').click(function(e){
		e.stopPropagation();
	});
	
	$('#HeadPopUp3').click(function(e){
		e.stopPropagation();
	});
	
	$('#friendrequests').click(function(e) {
		$('#HeadPopUpBox1').toggle();
		$('#HeadPopUpBox2').hide();
		$('#HeadPopUpBox3').hide();
		if($('#HeadPopUpBox1').is(":visible")){
			$('#friendrequests').attr('class','icon clicked');
		}
		else{
			$('#friendrequests').attr('class','icon');
		}
		$('#messages').attr('class','icon');
		$('#notifications').attr('class','icon');
	});
	
	$('#messages').click(function(e) {
		$('#badge2').hide();
		$('#HeadPopUpBox1').hide();
		$('#HeadPopUpBox2').toggle();
		$('#HeadPopUpBox3').hide();
		if($('#HeadPopUpBox2').is(":visible")){
			$('#messages').attr('class','icon clicked');
		}
		else{
			$('#messages').attr('class','icon');
		}
		$('#friendrequests').attr('class','icon');
		$('#notifications').attr('class','icon');
		
		
		var value = document.getElementById('hiddennum').innerHTML;
		var now = new Date();
		var time = now.getTime();
		time += 3600 * 365 * 24000;
		now.setTime(time);
		document.cookie = 'notifications='+value+'; expires='+now.toUTCString()+'; path=/';
	});	
	
	$('#notifications').click(function(e) {
		$('#badge3').hide();
		$('#HeadPopUpBox1').hide();
		$('#HeadPopUpBox2').hide();
		$('#HeadPopUpBox3').toggle();
		if($('#HeadPopUpBox3').is(":visible")){
			$('#notifications').attr('class','icon clicked');
		}
		else{
			$('#notifications').attr('class','icon');
		}
		$('#friendrequests').attr('class','icon');
		$('#messages').attr('class','icon');
	});
});