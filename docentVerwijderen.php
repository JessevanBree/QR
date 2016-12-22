<?php
	$id = $_GET['id'];
	//Verbinding maken met de datababase
	require_once("database.php");

	$sqliDocentNaam = "SELECT docentid, Naam FROM docenten WHERE docentid ='$id'";
	$sqliDocentNaamUitvoer = mysqli_query($connect, $sqliDocentNaam);
	$row = mysqli_fetch_array($sqliDocentNaamUitvoer);
	$naam = $row['Naam'];
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../Afbeeldingen/login.png">

    <title>Docent Verwijderen</title>

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
            <p class="navbar-text">Docent Verwijderen</p>
        </div>
    </div>
</nav>
<!-- Einde navbar -->

<!-- Begin Formulier-->
<form action="" method="post">
    <div class="col-md-5 col-md-offset-1 well">

        <?php echo "<b><h3>Weet u zeker dat u de docent <b>". $naam ."</b> wil verwijderen</h3></b>"; ?>

        <input type="radio" name="check" value="ja" > Ja<br>
        <input type="radio" name="check" value="nee" checked> Nee<br>

        <input class="btn btn-default" type="submit" value="submit" name="submit">
    </div>
</form>

<?php
    if (isset($_POST["submit"])) {
		if($_POST["check"] == 'ja'){
			$sqlDocentVerwijderen = "DELETE FROM docenten WHERE docentid ='".$id."'";
			$sqldocentinlogverwijdern = "DELETE FROM inloggegevens WHERE docid = '".$id."'";
			//var_dump($sqlDocentVerwijderen);
			mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=0");
			if(mysqli_query($connect, $sqlDocentVerwijderen) && mysqli_query($connect, $sqldocentinlogverwijdern)){
				mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=1");
				header("location:adminPagina.php");
			}
			else{
				echo"error";
			}
		}
		else{
			header("location:adminPagina.php");
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