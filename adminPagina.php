<?php
//Verbinding maken met de datababase
include_once("database.php");

?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../Afbeeldingen/login.png">

        <title>Admninstrator Paneel</title>

        <!-- Bootstrap core CSS -->
        <link href="Bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="style3.css" rel="stylesheet">
    </head>

        <body>
        <!-- Navbar -->
        <nav class="navbar navbar-QR ">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">QR-Code</a>
                    <p class="navbar-text NavText">Administrator Paneel</p>
                </div>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a href="docentToevoegen.php" class="btn-style:hover" >Docent toevoegen</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="Inlog/loguit.php"><span class="glyphicon glyphicon-log-out"></span> Uitloggen</a></li>
                    <!--Uitloggen knop -->
                </ul>
            </div>
        </nav>
        <!-- Einde navbar -->

        <div class="TopPadding">
            <!-- Eerste column -->
            <div class="col-md-3 well col-md-offset-1">
                <h3 class="text-center">Docenten</h3>
                <?php
                //voert de querry uit die de uren uit de database haalt.
                $sqliDNaam = "SELECT docentid, Naam FROM docenten";
                $sqliDNaamUitvoer = mysqli_query($connect, $sqliDNaam);
                //zet in de eerste regel van de tabel wat iedere rij voor waarde heeft.
                echo"<table class='table table-condensed'>";
                    echo "<tr>";
                        echo"<td>";
                            echo "<b>Naam Docent</b>";
                            echo"</td>";
                        echo"<td>";
                            echo "<b>Wijzigen</b>";
                        echo"</td>";

                        echo"<td>";
                            echo "<b>Verwijderen</b>";
                        echo"</td>";
						
						echo"<td>";
                            echo "<b>QR code generen</b>";
                        echo"</td>";
                    echo"</tr>";
                    //zet alle Docent namen in een tabel.
                    while($row = mysqli_fetch_array($sqliDNaamUitvoer)){
                        echo "<tr>";
                            echo"<td>";
                                echo "<a href='docent.php?id=".$row["docentid"]."'>".$row["Naam"]."</a>";
                            echo"</td>";

                            echo"<td>";
                                echo "<a href='docentWijzigen.php?id=".$row["docentid"]."'><span class='glyphicon glyphicon-pencil'></span> Wijzigen</a>";
                            echo"</td>";

                            echo"<td>";
                                echo "<a href='docentVerwijderen.php?id=".$row["docentid"]."'><span class='glyphicon glyphicon-remove'></span> Verwijderen</a>";
                            echo"</td>";
							
							echo"<td>";
								$actual_link = "http://$_SERVER[HTTP_HOST]" . "/" . "!klaar%20voor%20oplevering/QR/docent.php?id=".$row["docentid"] ;
								echo "<a href='QR/index.php?data=".$actual_link."'>QR-Code</a>";
							echo"</td>";
							
                        echo"</tr>";
                    }
                    echo "</table>";
                ?>
            </div>
            <!-- Tweede column -->
            <div class="col-md-6 col-md-offset-1 well">
                    <!-- Vak toeveogen -->
                    <form method="post" action="">
                        <label for="VakToevoegen">Vak Toevoegen</label></br>
                            <input type="text" name="VakToevoegen" placeholder="Vak Toevoegen" value="<?php echo isset($_POST['VakToevoegen']) ? $_POST['VakToevoegen'] : '' ?>" class="form-control VakInvoegen">
                            <input class="btn-verzend btn btn-default btn-verzend" type="submit" value="Vak toevoegen" name="submit">
                    </form>

                    <form method="post" action="">
                        <label for="vak">Lesvak:</label>
                            <select class="form-control VakInvoegen" name="VakVerwijderen">
                                <?php
                                //Maakt een query om de vakken op te halen uit de database
                                $sqliVakken = "SELECT vakid,vaknaam FROM vakken";
                                $sqliVakkenUitkomst = mysqli_query($connect, $sqliVakken);
                                echo "<option value='0'>Vak Verwijderen</option>";
                                while($row = mysqli_fetch_array($sqliVakkenUitkomst)){
                                    echo "<option value='" . $row["vakid"] . "'>" . $row["vaknaam"] . "</option>";
                                }
                                ?>
                            </select>
                            <input class="btn-verzend btn btn-default btn-verzend" type="submit" value="Vak Verwijderen" name="submit">
                    </form>
                    <br><br>
                    <?php
                    if(isset($_POST["submit"])){
                        // Een vak toevoegen
                        if(isset($_POST["VakToevoegen"])){
                            $sqliVakInvoegen = "INSERT INTO vakken (vakid, vaknaam) VALUES (DEFAULT , '".$_POST["VakToevoegen"]."')";
                            if(mysqli_query($connect, $sqliVakInvoegen)) {
                                echo "<h4 class='text-center'>Het vak is succesvol toegevoegd.</h4>";
                                HEADER("Refresh:1");
                            }
                            else{
                                echo "<h4 class='text-center'>er is een fout opgetreden, probeer het opnieuw</h4>";
                                HEADER("Refresh:1");
                            }
                        }
                        // Het vak verwijderen
                        if(isset($_POST["VakVerwijderen"])){
                            $sqliVerwijderen = "DELETE FROM vakken WHERE vakid='".$_POST["VakVerwijderen"]."'";
                            if(mysqli_query($connect, $sqliVerwijderen)) {
                                echo "<h4 class='text-center'>Het vak is succesvol Verwijderd</h4>";
                            }
                            else{
                                echo "<h4 class='text-center'>er is een fout opgetreden, probeer het opnieuw</h4>";
                            }
                        }
                    }
                    ?>
                    <!-- Knoppen naar andere pagina's -->
                    <label for="">Admin/Docent Toevoegen</label>
                        <div class="well text-center">
                            <a href="adminToevoegen.php"><span class="glyphicon glyphicon-plus"></span> Admin toevoegen</a>
                        </div>
                        <br>
                        <div class="well text-center">
                            <a href="docentToevoegen.php"><span class="glyphicon glyphicon-plus"></span> Docent toevoegen</a>
                        </div>
                </div>
        </div>

        <div class="footer navbar-fixed-bottom">
            Docent informatie 2016.
            </br>
            &copy; Koen van Kralingen, Paul Backs, Mike de Decker en Jesse van Bree.
        </div>
    </body>
</html>
