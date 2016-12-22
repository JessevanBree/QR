<?php
    //Verbinding maken met de datababase
    require_once("database.php");
    require_once("FotoUp.php");
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../Afbeeldingen/login.png">

        <title>Docent Toevoegen</title>

        <!-- Bootstrap core CSS -->
        <link href="Bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="style3.css" rel="stylesheet">
    </head>

    <body>
		<!-- Navbar -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<a class="navbar-brand" href="#">QR-Code</a>
					<p class="navbar-text">Docent toevoegen</p>
				</div>
				<ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a href="adminPagina.php" class="btn-style:hover" >adminPagina</a>
                    </li>
                </ul>
			</div>
		</nav>
		<!-- Einde navbar -->

		<!-- Begin Formulier-->
		<form action="" method="post">
			<div class="col-md-5 col-md-offset-1">
				<div class="form-group">
					<label for="Docent">De Docent waar u de inloggegevens van wil toevoegen</label>
					<select class="form-control" name="Docent">
						<?php
							
							//vult de box al voor je in als de post geweest is.
							if(isset($_POST["Docent"])){
								//vraagt de naam op van de docent(dit is nodig want in de post staat alleen een ID)
								$sqli_docentNaam_from_ID = "SELECT Naam FROM docenten WHERE docentid = '".$_POST["Docent"]."'";
								$sqli_docentNaan_from_ID_Uitkomst = mysqli_query($connect, $sqli_docentNaam_from_ID);
								$row = mysqli_fetch_array($sqli_docentNaan_from_ID_Uitkomst);
								echo "<option value='".$_POST["Docent"]."'>".$row["Naam"]."</option>";
							}
							else{
								echo "<option value='0'>Selecteer een docent</option>";
							}
							
							
							
							//haalt alle Docent namen op uit de database
							$sqli_docentNaam = "SELECT docentid, Naam FROM docenten";
							$sqli_docentNaam_Uitkomst = mysqli_query($connect, $sqli_docentNaam);
							while($row = mysqli_fetch_array($sqli_docentNaam_Uitkomst)){
								echo "<option value='".$row["docentid"]."'>".$row["Naam"]."</option>";
							}
						?>
					</select>
				</div>
				
				<label for="Naam Docent">Gebruikers naam docent</label>
				<input type="text" name="Gebruikers_Naam" placeholder="Gebruikers naam" class="form-control" value="<?php echo isset($_POST["Gebruikers_Naam"]) ?  $_POST["Gebruikers_Naam"] : '' ?>" required>

				<label for="Wachtwoord">Tijdelijk wachtwoord Docent:</label>
				<input type="text" name="Wachtwoord" placeholder="Wachtwoord" class="form-control" min="0" max="99"  required>
				
				<label for="Wachtwoord">Tijdelijk wachtwoord Docent nog maals:</label>
				<input type="text" name="Wachtwoord_check" placeholder="Wachtwoord nog maals" class="form-control" min="0" max="99"  required>
				
				<div class="form-group">
					<label for="Admin">Admin:</label>
					<select class="form-control" id="Admin" name="admin">
						<option value=1>Ja</option>
						<option value=0>Nee</option>
					</select>
				</div>
				

				<br>
				<br>
				<input class="btn btn-default" type="submit" value="submit" name="submit">
				<br>
				<br>
			
		</form>
	
		<?php
			//controleert of de post al gebeurt is
			if(isset($_POST["submit"])){
				if($_POST["Wachtwoord"] == $_POST["Wachtwoord_check"]){
					//de gegevens zijn goed, dus het kan in de database worden gezet
					$sqli_inloggegevens_insert = "INSERT INTO inloggegevens (inlogID, docid, gebruikersnaam, wachtwoord, Zout, Admin, Eerste_Inlog) VALUES (DEFAULT, '".$_POST["Docent"]."', '".$_POST["Gebruikers_Naam"]."', '".$_POST["Wachtwoord"]."', '". 0 ."', '".$_POST["admin"]."', '". 1 ."')";
					if(mysqli_query($connect, $sqli_inloggegevens_insert)){
						echo "de inloggegevens zijn succesvol aangemaakt.";
					}
					else{
						echo "er is een onbekende fout opgetreden, probeer het op nieuw.";
					}
				}
				else{
					echo "de opgegeven wachtwoorden komen niet overeen.";
				}
			}
		?>
		
			</div>
        <div class="footer navbar-fixed-bottom">
            Docent informatie 2016.
            </br>
            &copy; Koen van Kralingen, Paul Backs, Mike de Decker en Jesse van Bree.
        </div>
    </body>
</html>
