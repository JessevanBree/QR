<html>
	<body>
		<?php
			//error_reporting(0);
			function inloggen($username, $password){
				require_once("encryptie.php");
				require_once("../database.php");
				
				session_start();
					
				//verdedigen tegen SQL injection
				//stripcslashes haalt alle ongewenste tekens uit de ingevoerde waarde.
				$username = stripcslashes($username);
				$password = stripcslashes($password);
				//zorgt er voor dat de speciale teken uit de ingevoerde waarde wordt gehaald.
				$username = mysqli_real_escape_string($connect, $username);
				$password = mysqli_real_escape_string($connect, $password);
				
				//controleerdt of er voor de eerste keer wordt ingelogt
				$sqli = "SELECT inlogID, Zout FROM inloggegevens WHERE gebruikersnaam='$username' AND wachtwoord='$password'"; 
				$uitkomst = mysqli_query($connect, $sqli);
				if(mysqli_num_rows($uitkomst) >= 1){
					//je bent voor het eerst ingelogt.
					//je wordt door verwezen naar een andere pagina om je wachtwoord intestellen. 
					header("location:wachtwoord_wijzigen.php");
				}
				else{
					//je bent niet voor het eerst ingelogt.
					//encrypt het wachtwoord zodat deze kan worden vergeleken met het wachtwoord in de database
					//maakt de querry die de salt uit de database opvraagt. 
					$sqli_salt = "SELECT Zout FROM inloggegevens WHERE gebruikersnaam = '$username'";
					$result = mysqli_query($connect, $sqli_salt);
					$TEMP = mysqli_fetch_array($result);
					$salt = $TEMP[0];
					//var_dump($TEMP[0]);
					//conbineerd de salt en het wachtwoord.
					$password = $password . $salt;
					//encrypt het wachtwoord. (gebruikt eigengemaakte functie)
					$password = encryptie($password);
					//var_dump($password);
					//controleerdt de username en password in de database
					//maakt de querry voor het selecteren van de gegevens.
					$sqli = "SELECT inlogID FROM inloggegevens WHERE gebruikersnaam='$username' AND wachtwoord='$password'"; 
					var_dump($sqli);
					//voert de querry $sqli uit en zet de uitkomst in een variablen.
					$uitkomst = mysqli_query($connect, $sqli);
					$row = mysqli_fetch_array($uitkomst);
					
					//als de gebruikers naam en wachtwoord in de database zijn word er een session begonnen.
					//als de gegevens niet in de database voor komen wordt er een vout melding gegeven. 
					if(mysqli_num_rows($uitkomst) >= 1){
						//zorgt er voor dat de andere pagina's kunnen controleren of er ingelogt is.
						$_SESSION["ingelogt"] = true;
						//zet je inlognaam in een variablen.
						$_SESSION["Inlog_ID"] = $row["inlogID"];
						//je wordt door gestuurd naar de hoofd pagina. 
						header("location: ../Index.php");
					}
					else{
						echo "onjuiste gebruikers naam of wachtwoord";
					}
				}
				
				
				
				
				
				
				//$sqli="SELECT * FROM login WHERE username='$username' AND password='$password'"; 
			}
		?>
		
	</body>
<html>