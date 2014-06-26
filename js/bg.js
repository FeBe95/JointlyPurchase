(function(){
	var canvas = document.getElementById("bgCanvas");  
	var ctx = canvas.getContext("2d");
		
	initialize();
	
	function initialize(){
		window.addEventListener('resize', resizeCanvas, false);
	}
	
	function resizeCanvas(){
		canvas.width = window.innerWidth;
		canvas.height = window.innerHeight;
		drawStuff(color);
	}
	
	resizeCanvas();
	
	function drawStuff(color, colorTrue){
		var width = canvas.width;
		var height = canvas.height;
		var positiony = 0;
		var positionx = 0;
		var Blockwidth = width;
		while(Blockwidth > 100){
			Blockwidth=Blockwidth/2;
		}
		AnzahlBlocks = width/(Blockwidth+0) ;
		var Differenz = width/(AnzahlBlocks*(Blockwidth+0));
		Blockwidth = Blockwidth-(Blockwidth/AnzahlBlocks)-0;
		var rectwidth= Blockwidth;
		var randomMin = 1;
		var randomMax = 6;
		
		//Schleife zum Zeichnen der Blöcke.
		while(positionx < height){
			while(positiony < width-rectwidth){
				var zufall = Math.floor(Math.random() * (randomMax - randomMin)) + randomMin;
					ctx.fillStyle ="#"+color[zufall]+"";
					ctx.fillRect(positiony,positionx,rectwidth,rectwidth);
					positiony += rectwidth +0;
			}
			positionx += rectwidth +0;
			positiony = 0;
		}
	}
})();
			