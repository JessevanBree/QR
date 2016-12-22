<?php
//Kijken of waardes numeriek zijn
if(is_numeric($_GET['id'])) {
    //Rond nummer af
    $id = round($_GET['id']);
    //verbinding maken met Database
    require_once("database.php");
    require_once("FotoUp.php");
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
        $sqli_fav_vak = "SELECT vakken.vakid, vaknaam FROM vakken JOIN fav_vak ON vakken.vakid = fav_vak.vakid WHERE fav_vak.docid = '$id'";
        $row_fav_vak = mysqli_fetch_array(mysqli_query($connect, $sqli_fav_vak));
        //haalt het Les vak op
        $sqli_Les_Vak = "SELECT vakken.vakid, vaknaam FROM vakken JOIN lesvak ON vakken.vakid = lesvak.vakid WHERE lesvak.docid = '$id'";
        $row_Les_Vak = mysqli_fetch_array(mysqli_query($connect, $sqli_Les_Vak));
    }
    else{
        //header("location: adminPagina.php");
    }
}
else{
    //header("location: adminPagina.php");
}
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../Afbeeldingen/login.png">

        <title>Docent Wijzigen</title>

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
                    <p class="navbar-text">Docent Wijzigen</p>
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-3 col-md-offset-1">
                <label for="Naam Docent">Naam Docent:</label>
                    <input type="text" name="naamDocent" placeholder="Naam Docent" class="form-control" value="<?php echo $naam; ?>">
                <label for="Leeftijd">Leeftijd:</label>
                    <input type="number" name="leeftijd" placeholder="Leeftijd" class="form-control" min="0" max="99" value="<?php echo $Leeftijd; ?>">
                <label for="vak">Lesvak:</label>
                    <select class="form-control" name="lesVak">
                        <?php
                            //Maakt een query om de vakken op te halen uit de database
                            $sqliLesVak = "SELECT vakid,vaknaam FROM vakken";
                            $sqliLesVakUitkomst = mysqli_query($connect, $sqliLesVak);
                            echo "<option value='".$row_Les_Vak["vakid"] . "'>".$row_Les_Vak["vaknaam"]."</option>";
                            while($row = mysqli_fetch_array($sqliLesVakUitkomst)){
                                echo "<option value='" . $row["vakid"] . "'>" . $row["vaknaam"] . "</option>";
                            }
                        ?>
                    </select>
            </div>

            <div class="col-md-3">
                <label for="Opleiding">Opleiding:</label>
                    <input type="text" name="opleiding" placeholder="Opleiding" class="form-control" value="<?php echo $Opleiding ?>">
                <label for="Favoriete vak">Favoriete vak:</label>
                    <select class="form-control" name="favvak">
                        <?php
                            //Maakt een query om de vakken op te halen uit de database
                            $sqliFavVak = "SELECT vakid,vaknaam FROM vakken";
                            $sqliFavVakUitkomst = mysqli_query($connect, $sqliFavVak);
                            echo "<option value='".$row_fav_vak["vakid"]."'>".$row_fav_vak["vaknaam"]."</option>";
                            while($row = mysqli_fetch_array($sqliFavVakUitkomst)){
                                echo "<option value='" . $row["vakid"] . "'>" . $row["vaknaam"] . "</option>";
                            }
                        ?>
                    </select>
                <label for="FotoUploaden:">Foto uploaden:</label><br>
                    <input type="file" name="bestand" placeholder="Uploaden" value="bestand" accept="image/jpeg" class="btn btn-style">
            </div>

            <div class="col-md-3">
                <label for="beschrijving">beschrijving:</label>
                <textarea name="beschrijving" class="form-control" rows="5" id="comment" placeholder="<?php echo $Beschrijving; ?>"><?php echo $Beschrijving; ?></textarea>
            </div>

            <br>
            <div class="col-md-offset-4 col-md-3">
                <input class="col-md-offset-2 col-md-8 btn-verzend btn btn-default btn-verzend" type="submit" value="submit" name="submit"><br><br>
        </form>
        <!-- Einde Formulier-->

        <!-- Begin PHP-POST gedeelte om de gegevens na te kijken en als alles correct is het in de database te stoppen -->
        <?php
            if (isset($_POST["submit"])){
                if (isset($_POST["naamDocent"]) && ($_POST["leeftijd"]) && /*($_FILES['bestand']) &&*/ ($_POST["lesVak"]) && ($_POST["opleiding"]) && ($_POST["favvak"]) && ($_POST["beschrijving"])){
                    $sqlDocentAanpassen = "UPDATE docenten SET Naam='".$_POST["naamDocent"]."', Opleiding='".$_POST["opleiding"]."', Beschrijving='".$_POST["beschrijving"]."', Leeftijd='".$_POST["leeftijd"]."', Afbeeldingspad='' WHERE docentid ='$id'";
                    //$sqlDocentToevoegen = "INSERT INTO docenten (docentid, Naam, Opleiding, Beschrijving, Leeftijd, Afbeeldingspad) VALUES (DEFAULT, '".$_POST["naamDocent"]."', '".$_POST["opleiding"]."', '".$_POST["beschrijving"]."', '".$_POST["leeftijd"]."'/*, '".$_POST["FotoUp"]."')*/";
                     mysqli_query($connect, $sqlDocentAanpassen);
                    $sqlDocentOphalen = "SELECT docentid FROM docenten WHERE Naam='".$_POST["naamDocent"]."'";
                    $sqliDocentID = mysqli_query($connect, $sqlDocentOphalen);
                    $row = mysqli_fetch_array($sqliDocentID);
					
                    $sqliFavVakAanpassen = "UPDATE fav_vak SET docid='".$row["docentid"]."',vakid='".$_POST["favvak"]."'";
                    $sqliLesVakAanpassen = "UPDATE lesvak SET docid='".$row["docentid"]."',vakid='".$_POST["lesVak"]."'";
                    if(mysqli_query($connect, $sqliFavVakAanpassen) && mysqli_query($connect, $sqliLesVakAanpassen))
                    {
						//roept de functie aan die de foto upload regelt.
						if(foto_upload($_FILES, $_POST['naamDocent'], $row["docentid"]) == true){
							echo "<h4 class='text-center'>De docent is gewijzigd</h4>";
						}
						else{
							echo "<h4 class='text-center'>er is een fout opgetreden, probeer het opnieuw</h4>";
						}
                    }
                    else
                    {
                        echo "<h4 class='text-center error'>er is iets fout gegaan</h4>";
                    }
                }
                else
                {
                    echo "<h4 class='text-center'>Niet alle invulvakken zijn ingevuld</h4>";
                }
            }
        ?>
            </div>

            <!-- Begin Footer -->
            <div class="footer navbar-fixed-bottom">
                <p>Docent informatie 2016.<p>
                <p>&copy; Koen van Kralingen, Paul Backs, Mike de Decker en Jesse van Bree.<p>
            </div>
            <!-- Einde Footer -->
    </body>
</html>