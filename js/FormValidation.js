function validate(sender,myarray,err_hd) {
	
	var err_msg = !err_hd?new Array('Folgende Fehler sind aufgetreten:\n'):new Array(err_hd+'\n');
	var error = false;
	
	for (i=0;i<myarray.length;i++) {
		field = document.forms[sender.name].elements[myarray[i][0]];
		
		/* Block 1 überprüft Felder, die ausgefüllt sein müssen */
		if (myarray[i][1].indexOf('e')>-1) {
			if (!field.value) {
			error = true;
			err_msg.push(myarray[i][2]);
			}
		}
		
		/* Block 2 überprüft, ob die Emailadresse formal richtig ist */
		else if (myarray[i][1].indexOf('m')>-1) {
			if (field.value) {
			var usr = "([a-zA-Z0-9][a-zA-Z0-9_.-]*|\"([^\\\\\x80-\xff\015\012\"]|\\\\[^\x80-\xff])+\")";
			var domain = "([a-zA-Z0-9][a-zA-Z0-9._-]*\\.)*[a-zA-Z0-9][a-zA-Z0-9._-]*\\.[a-zA-Z]{2,5}";
			var regex = "^"+usr+"\@"+domain+"$";
			var myrxp = new RegExp(regex);
			var check = (myrxp.test(field.value));
				if (check!=true) {
				error=true;
				err_msg.push(field.value+" "+myarray[i][2]);
				}
			}
		}
		
		/* Block 3 überprüft Felder, deren Wert eine Zahl sein muss */
		else if (myarray[i][1].indexOf('n')>-1) {
			var num_error = false;
			if(field.value) {
				var myvalue = field.value;
				var num = myvalue.match(/[^0-9,\.]/gi)
				var dot = myvalue.match(/\./g);
				var com = myvalue.match(/,/g);
				if (num!=null) {
					num_error = true;
				}
				else if ((dot!=null)&&(dot.length>1)) {
					num_error = true;
				}
				else if ((com!=null)&&(com.length>1)) {
					num_error = true;
				}
				else if ((com!=null)&&(dot!=null)) {
					num_error = true;
				}
			}
			if (num_error==true) {
				error = true;
				err_msg.push(myvalue+" "+myarray[i][2]);
			}
		}
		
		/* Block 4 überprüft Wert anhand eines regulären Audrucks auf bestimmte Muster */
		else if (myarray[i][1].indexOf('r')>-1) {
			var regexp = myarray[i][3];
			if (field.value) {
				if (!regexp.test(field.value)) {
					error = true;
					err_msg.push(field.value+" "+myarray[i][2]);
				}
			}
		}
		
		/* Block 5 überprüft Felder, die als Preis formatiert sein müssen, ändert die Formatierung eventuell */
		else if (myarray[i][1].indexOf('p')>-1) {
			var myvalue = field.value;
			var reg = /,-{1,}|\.-{1,}/;
			var nantest_value = myvalue.replace(reg,"");
			var num = nantest_value.match(/[^0-9,\.]/gi)
			sep = myarray[i][1].substr(1,1)?myarray[i][1].substr(1,1):',';
			if (field.value) {
				var myvalue = field.value.replace(/\./,',');
				if (myvalue.indexOf(',')==-1) {
					field.value = myvalue+sep+'00';
				}
				else if (myvalue.indexOf(",--")>-1) {
					field.value = myvalue.replace(/,--/,sep+'00');
				}
				else if (myvalue.indexOf(",-")>-1) {
					field.value = myvalue.replace(/,-/,sep+'00');
				}
				else if (!myvalue.substring(myvalue.indexOf(',') + 2)) {
					error=true;
					err_msg.push(field.value+" "+myarray[i][2]);
				}
				else if (myvalue.substring(myvalue.indexOf(',') + 3)!='') {
					error=true;
					err_msg.push(field.value+" "+myarray[i][2]);
				}
				else if (num!=null) {
					error=true;
					err_msg.push(field.value+" "+myarray[i][2]);
				}
			}
		}
		
		/* Block 6 überprüft Namensfelder, und korrigiert evtl. die Groß-/Kleinschreibung */
		else if (myarray[i][1].indexOf('c')>-1) {
			var noble = new Array("de","von","van","der","d","la","da","of");
			var newvalue='';
			var myvalue = field.value.split(/ /); //nicht (/\b/), weil dann üöäß nicht gehen!
			for (k=0;k<myvalue.length;k++) {
				newvalue+= myvalue[k].substr(0,1).toUpperCase()+myvalue[k].substring(1)+" "; // " " ist Leerzeichen-Fix
			}
			for(k=0;k<noble.length;k++){
				var reg = new RegExp ("\\b"+noble[k]+"\\b","gi");
				newvalue = newvalue.replace(reg,noble[k]);
			}
			field.value = newvalue;
		}
	}
	
	/* im Fehlerfall werden hier die gesammelten Fehlermeldungen verarbeitet und angezeigt. Wenn das
	Formular ohne Beanstandung ist, wird es übertragen */
	if (error) {
		err_msg = err_msg.join('\n\xB7 ');
		alert(err_msg);
		return false;
	}
	else {
		return true;
	}
}