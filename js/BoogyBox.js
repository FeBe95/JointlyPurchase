$( document ).ready(function() {
//<![CDATA[
$(window).load(function(){
$('html').click(function() {
    $('#HeadPopUpBox').hide();
 })

 $('#HeadPopUp').click(function(e){
     e.stopPropagation();
 });

$('#link').click(function(e) {
 $('#HeadPopUpBox').toggle();
  $('#HeadPopUpBox2').hide();
 });
});//]]>
});
$( document ).ready(function() {
//<![CDATA[
$(window).load(function(){
$('html').click(function() {
    $('#HeadPopUpBox2').hide();
 })

 $('#HeadPopUp2').click(function(e){
     e.stopPropagation();
 });

$('#link2').click(function(e) {
 $('#HeadPopUpBox2').toggle();
  $('#HeadPopUpBox').hide();
 });
});//]]>
});



