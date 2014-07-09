<?php
	$querydate = explode(" ", $dsatz["date"]);
	$qdate_formatiert = strftime("%d. %B",strtotime($querydate[0]));
	
	$now = time();
	$nowdate = date("d.m.Y",$now);
	$nowtime = date("H:i",$now);
	
	$date1 = new DateTime($nowdate);
	$date2 = new DateTime($querydate[0]);
	$interval = $date1->diff($date2);
	$tagezurück = $interval->days;
	
	if($tagezurück == 0){$zeit = "";}
	elseif($tagezurück == 1){$zeit = "Gestern ";}
	elseif($tagezurück == 2){$zeit = "Vorgestern ";}
	elseif($tagezurück > 2){$zeit = $qdate_formatiert;}
	
	$time1 = new DateTime($nowtime);
	$time2 = new DateTime($querydate[2]);
	$interval = $time1->diff($time2);
	$minutenzurück = $interval->i;
	$stundenzurück = $interval->h;
	
	if($tagezurück == 0 && $stundenzurück == 0 && $minutenzurück == 0){
		$zeit .= "vor ein paar Sekunden";
	}
	elseif($tagezurück == 0 && $stundenzurück == 0 && $minutenzurück == 1){
		$zeit .= "vor 1 Minute";
		//$zeit .= "1 Min.";
	}
	elseif($tagezurück == 0 && $stundenzurück == 0 && $minutenzurück < 60){
		$zeit .= "vor ".$minutenzurück." Minuten";
		//$zeit .= $minutenzurück." Min.";
	}
	elseif($tagezurück == 0 && $stundenzurück == 1){
		$zeit .= "vor 1 Stunde";
		//$zeit .= "1 Std.";
	}
	elseif($tagezurück == 0 && $stundenzurück < 24){
		$zeit .= "vor ".$stundenzurück." Stunden";
		//$zeit .= $stundenzurück." Std.";
	}
	else{
		$zeit .= " um ".$querydate[2];
	}
?>