<?php
	//Kijken of waardes numeriek zijn
	if(is_numeric($_GET['id'])) {
		//Rond nummer af
		$id = round($_GET['id']);

		//verbinding maken met Database
		require_once("database.php");

		
		//maakt een querry die de gegevens van de docent op haalt
		$sqli_docent_info = "SELECT Naam, Opleiding, Beschrijving, Leeftijd, Afbeeldingspad FROM docenten WHERE docentid ='$id'";
		$sqli_docent_info_uitkomst = mysqli_query($connect, $sqli_docent_info);
		if(mysqli_num_rows($sqli_docent_info_uitkomst) == 1){
			$row = mysqli_fetch_array($sqli_docent_info_uitkomst);
			
			//zet de nodige gegevens in een array
			$naam = $row['Naam'];
			$Opleiding = $row['Opleiding'];
			$Beschrijving = $row['Beschrijving'];
			$Leeftijd = $row['Leeftijd'];
			
			//haalt het favourite vak op
			$sqli_fav_vak = "SELECT vaknaam FROM vakken JOIN fav_vak ON vakken.vakid = fav_vak.vakid WHERE fav_vak.docid = '$id'";
			$row_fav_vak = mysqli_fetch_array(mysqli_query($connect, $sqli_fav_vak));
			$favVak = $row_fav_vak["vaknaam"];
		}
		else{
			header("location: Docent.php?id=1");
		}
	}
	else{
		header("location: Docent.php?id=1");
	}
?>
<!DOCTYPE html>
<html>
	<head>	
		<meta charset="utf-8">
		<title>Docent informatie</title>
		<!-- Bootstrap core CSS -->
		<link href="Bootstrap/css/bootstrap.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="style.css" rel="stylesheet">		
	</head>
	
	<body>
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'> <!-- google style sheet toevoegen -->
		<div class="container-fluid margin-footer"> <!-- hoofd container -->
			<div class="row kleur-effect text-opmaak"> <!-- groene gedeelte en witte text opmaak -->		
				<div align="center">
					<div class="line"><h1>Docent informatie</h1>	<!-- bovenste balk met titel en groene lijn-->
					</div>
					<div class="ring"><img src="<?php echo "Docenten/" . $naam . "/profile_picture.jpg"; ?>" class="image-circle"/> <!-- profiel foto -->
					</div>   
					<h1><?php echo $naam ?></h1> <!-- laat de naam zien -->
					<span>ICT</span>	<!-- standaard afdeling ict -->
				</div>
				<div class="col-md-6 col-xs-6 korte-info-opmaak line" align="center">	<!-- 1e grote groene veld met korte info -->
					<h2>
						 <?php echo $favVak ?> <br/> <span>Favourite vak</span>
					</h2>
				</div>	<!-- einde 1e korte info -->
				<div class="col-xs-6 col-md-6 korte-info-opmaak line" align="center">	<!-- 2e korte info veld -->
					<h2>
						 <?php echo $Leeftijd ?> <br/> <span>Leeftijd</span>
					</h2>
				</div>	<!-- einde 2e korte info veld -->		   
				<div class="col-xs-12 col-md-12 container-info">	<!-- witte container met informatie -->                
					<div class="info-container-opmaak">  
						<div class="col-mb-2 col-xs-2">	<!-- spaceing container -->
						</div>	<!-- einde cpaceing container -->
						<div class="info col-md-9 col-xs-9">	<!-- informatie container -->
							<h1>Docent informatie</h1>				
							<b>Leeftijd:</b>
							<?php echo $Leeftijd ?>	<!-- laat leeftijd zien -->
							<br>
							<b>Vakken:</b>
							<!-- laat de vakken zien met tussen de laatste 2 vakken een en ipv een , -->
							<?php
								//haalt de vakkken op uit de database.
								$sqli_vakken = "SELECT vaknaam FROM vakken JOIN lesvak ON vakken.vakid = lesvak.vakid WHERE lesvak.docid ='$id'";
								$row = mysqli_fetch_array(mysqli_query($connect, $sqli_vakken));
								
								echo ($row['vaknaam']);
							?>
							<!-- einde vakken laten zien -->
							<br>
							<b>Favouriten vak:</b>
							<?php echo $favVak ?>	<!-- laat favourite vak zien -->
							<br>
							<b>Opleiding:</b>
							<?php echo $Opleiding ?> <!-- laat opleiding zien -->
							<hr>
							<b>Beschrijving:</b>
							<?php echo $Beschrijving ?>	<!-- laat beschrijfing zien -->
						</div>	
						<div class="col-md-2 col-xs-2">	<!-- laatste spaceing container -->
						</div>	<!-- einde 2e spaceing container -->
					</div>    	    
				</div>
			</div>
		</div>
		<div class="footer"> <!-- footer text onder de hoofd container -->
			Docent informatie 2016.
			<br>
			&copy; Koen van Kralingen, Paul Backs, Jesse van Bree en Mike de Decker.
		</div>	<!-- einde footer text -->
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="../Bootstrap/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>