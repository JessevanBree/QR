<?php
	function wachtwoord_wijzigen($username, $password, $password_nieuw, $password_check){
		require_once("encryptie.php");
		require_once("../database.php");
		
		//controleert of de inloggegevens correct zijn.(leerlingen)
		$sqli_inlog_check = "SELECT * FROM inloggegevens WHERE gebruikersnaam='$username' AND wachtwoord='$password'";
		$sqli_inlog_check_uitkomst = mysqli_query($connect, $sqli_inlog_check);
		if(mysqli_num_rows($sqli_inlog_check_uitkomst) >=  1){
			//de inlog gegevens zijn goed dus het wachtwoord kan worden gewijzigd.
			//controleert of het nieuwe wachtwoord wel 2 keer goed is ingevoerd.
			if($password_nieuw == $password_check){
				//het wachtwoord moet een encryptie krijgen. voor de encryptie wordt ook een salt gebruikt.
				$salt = gen_salt();
				//voegt het wachtwoord smen met de salt.
				$password = $password_nieuw . $salt;
				//encrypt het wachtwoord
				$password = encryptie($password);
				
				//bereid de querry voor die het updaten van het wachtwoord doet.
				$sqli_password_update = "UPDATE inloggegevens SET wachtwoord='$password', Zout='$salt', Eerste_Inlog='0' WHERE gebruikersnaam='$username'";
				if(mysqli_query($connect, $sqli_password_update)){
					session_destroy();
					header("location: login.php");
				}
				else{
					echo "er is een onbekende vout op getreden, probeer het nog eens.";
				}
			}
			else{
				echo "de nieuwen wachtwoorden komen niet overeen.";
			}
		}
		else{
			echo "onjuiste gebruikers naam of wachtwoord";
		}
		
	}
	
?>

