
    <?php
$PicPathIn="../../Pictures/ProfilPictures/";
$PicPathOut="../../Pictures/Thumbnails/";

// Orginalbild
$bild=$newname;

// Bilddaten ermitteln
$size=getimagesize("$PicPathIn"."$bild");
$breite=$size[0];
$hoehe=$size[1];
$neueBreite=50;
$neueHoehe=intval($hoehe*$neueBreite/$breite);

if($size[2]==1) {
// GIF
$altesBild=ImageCreateFromGIF("$PicPathIn"."$bild");
$neuesBild=imageCreate($neueBreite,$neueHoehe);
imageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
imageGIF($neuesBild,"$PicPathOut"."$bild");
}

if($size[2]==2) {
// JPG
$altesBild=ImageCreateFromJPEG("$PicPathIn"."$bild");
$neuesBild=imageCreate($neueBreite,$neueHoehe);
imageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
ImageJPEG($neuesBild,"$PicPathOut"."$bild");
}

if($size[2]==3) {
// PNG
$altesBild=ImageCreateFromPNG("$PicPathIn"."$bild");
$neuesBild=imageCreate($neueBreite,$neueHoehe);
imageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
ImagePNG($neuesBild,"$PicPathOut"."$bild");
}

?> 