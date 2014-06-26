<?php
	if(isset($_POST)){
		############ Edit settings ##############
		$ThumbSquareSize        = 200; 								//Thumbnail will be 200x200
		$BigImageMaxSize        = 640; 								//Image Maximum height or width
		$ThumbPrefix            = "../Thumbnails/"; 				//Normal thumb Prefix
		$DestinationDirectory   = '../Pictures/ProfilPictures/';	//specify upload directory ends with / (slash)
		$Quality                = 90; 								//JPEG quality
		##########################################
	
		//check if this is an ajax request
		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die();
		}
	
		// check $_FILES['ImageFile'] not empty
		if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name'])){
			die('Irgendetwas ist schief gelaufen, bitte wähle ein anderes Foto!'); // output error when above checks fail.
		}
	
		// Random number will be added after image name
		$RandomNumber   = rand(0, 9999999999);
			
		//$ImageName      = str_replace(' ','-',strtolower($_FILES['ImageFile']['name'])); //get image name
		$ImageName      = preg_replace("/[^a-zA-Z0-9-.]/", "_", $_FILES["ImageFile"]["name"]);	//get image name
		$ImageSize      = $_FILES['ImageFile']['size'];
		$TempSrc        = $_FILES['ImageFile']['tmp_name'];
		$ImageType      = $_FILES['ImageFile']['type'];
	
		switch(strtolower($ImageType)){
			case 'image/png':
				$CreatedImage =  imagecreatefrompng($_FILES['ImageFile']['tmp_name']);
				imagealphablending($CreatedImage, true);	// PNG-Tranparenz-Fix
				break;
			case 'image/gif':
				$CreatedImage =  imagecreatefromgif($_FILES['ImageFile']['tmp_name']);
				break;         
			case 'image/jpeg':
			case 'image/pjpeg':
				$CreatedImage = imagecreatefromjpeg($_FILES['ImageFile']['tmp_name']);
				break;
			default:
				die('Nicht unterstützer Dateityp!'); //output error and exit
		}

		list($CurWidth,$CurHeight) = getimagesize($TempSrc);
	
		//Get file extension from Image name, this will be added after random name
		$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
		$ImageExt = str_replace('.','',$ImageExt);
	
		//remove extension from filename
		$ImageName      = preg_replace("/\\.[^.\\s]{3,4}$/", "", $ImageName);
	
		//Construct a new name with random number and extension.
		$NewImageName = $ImageName.'-'.$RandomNumber.'.'.$ImageExt;
	
		//set the Destination Image
		$thumb_DestRandImageName    = '../'.$DestinationDirectory.$ThumbPrefix.$NewImageName; //Thumbnail name with destination directory
		$DestRandImageName          = '../'.$DestinationDirectory.$NewImageName; // Image with destination directory
	
		//Resize image to Specified Size by calling resizeImage function.
		if(resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$DestRandImageName,$CreatedImage,$Quality,$ImageType))
		{
			//Create a square Thumbnail right after, this time we are using cropImage() function
			if(!cropImage($CurWidth,$CurHeight,$ThumbSquareSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType))
				{
					echo 'Error Creating thumbnail';
				}
			/*
			We have succesfully resized and created thumbnail image
			*/
			?>
			
			<table border="0" cellpadding="4" cellspacing="0">
				<tr>
					<td align="center">
						<p class="formError">Du kannst dieses Bild übernehmen, ein anderes hochladen oder den Vorgang abbrechen</p>
						<br/>
						<form name="updatePic" action="../Pages/ProfilSettings.php?success" method="post">
							<input name="submit" type="submit" value="Übernehmen"/>
							<input name="NewImage" type="hidden" value="<?php echo $NewImageName;?>"/>
						</form>
						<br/>
						<button onclick="location.href = 'ProfilSettings.php'">Abbrechen</button>
						<br/>
						<br/>
					</td>
				</tr>
				<tr>
					<td align="center"><img src="<?php echo $DestinationDirectory.$NewImageName ?>" alt="Resized Image"></td>
				</tr>
			</table>
			
		<?php
	
		}else{
			die('Resize Error'); //output error
		}
	}
	
	
	// This function will proportionally resize image
	function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
	{
		//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0)
		{
			return false;
		}
	
		//Construct a proportional size of new image
		$ImageScale         = min($MaxSize/$CurWidth, $MaxSize/$CurHeight);
		$NewWidth           = ceil($ImageScale*$CurWidth);
		$NewHeight          = ceil($ImageScale*$CurHeight);
		$NewCanves          = imagecreatetruecolor($NewWidth, $NewHeight);
		imagealphablending($NewCanves, false);		// PNG-Tranparenz-Fix
		imagesavealpha($NewCanves, true);			// PNG-Tranparenz-Fix
	
		// Resize Image
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
		{
			switch(strtolower($ImageType))
			{
				case 'image/png':
					imagepng($NewCanves,$DestFolder);
					break;
				case 'image/gif':
					imagegif($NewCanves,$DestFolder);
					break;         
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanves,$DestFolder,$Quality);
					break;
				default:
					return false;
			}
		//Destroy image, frees memory  
		if(is_resource($NewCanves)) {imagedestroy($NewCanves);}
		return true;
		}
	
	}
	
	//This function corps image to create exact square images, no matter what its original size!
	function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
	{    
		//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0)
		{
			return false;
		}
	
		//abeautifulsite.net has excellent article about "Cropping an Image to Make Square bit.ly/1gTwXW9
		if($CurWidth>$CurHeight)
		{
			$y_offset = 0;
			$x_offset = ($CurWidth - $CurHeight) / 2;
			$square_size    = $CurWidth - ($x_offset * 2);
		}else{
			$x_offset = 0;
			$y_offset = ($CurHeight - $CurWidth) / 2;
			$square_size = $CurHeight - ($y_offset * 2);
		}
	
		$NewCanves  = imagecreatetruecolor($iSize, $iSize);
		imagealphablending($NewCanves, false);		// PNG-Tranparenz-Fix
		imagesavealpha($NewCanves, true);			// PNG-Tranparenz-Fix
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
		{
			switch(strtolower($ImageType))
			{
				case 'image/png':
					imagepng($NewCanves,$DestFolder);
					break;
				case 'image/gif':
					imagegif($NewCanves,$DestFolder);
					break;         
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanves,$DestFolder,$Quality);
					break;
				default:
					return false;
			}
		//Destroy image, frees memory  
		if(is_resource($NewCanves)) {imagedestroy($NewCanves);}
		return true;
	
		}
		
	}
?>
