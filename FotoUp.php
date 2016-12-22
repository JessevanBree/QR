<?php
function foto_upload($bestand, $DocentNaam, $docentID){
	//require_once("DB.php");
	
	//Databasegegevens
	$Host = "localhost";
	$Pass = "usbw";
	$Username = "root";
	$DBName = "qrcode";

	$connectie = mysqli_connect("$Host", "$Username", "$Pass", "$DBName");
	
	
	//controleerd of de map (dir) bestaad.
	if(!file_exists("Docenten/".$DocentNaam)){
		mkdir("Docenten/".$DocentNaam, 0750);
	}
	
	//controleerd of het wel een img is.
	$check = getimagesize($bestand["bestand"]["tmp_name"]);
	if($check !== false){
		$gebruikers_map = "Docenten/".$DocentNaam."/";
		$bestandnaam = 'profile_picture.jpg';
		
		//converteed de afbeelding naar de standaard maat.
		//steld de nieuwe waardes in
		$new_width = 255;
		$new_height = 255;
		list($width, $height) = getimagesize($bestand["bestand"]["tmp_name"]);//imagecopyresampled
		
		//laad de afbeelding
		$img_resized = imagecreatetruecolor($new_width, $new_height);
		$source = imagecreatefromjpeg($bestand["bestand"]["tmp_name"]);
		
		//resize
		imagecopyresampled($img_resized, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
		//slaat de afbeelding op in de aangegeven map.
		imagejpeg($img_resized, $gebruikers_map.$bestandnaam);
		$afbeeldingspad = $gebruikers_map.$bestandnaam ; 
		//maakt de querry die de path van de foto in de db zet
		$sqli_update_foto = "UPDATE docenten SET Afbeeldingspad = '$afbeeldingspad' WHERE docentid='$docentID'";
		if(mysqli_query($connectie, $sqli_update_foto)){
			return true;
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
	
}
	
	
?>


