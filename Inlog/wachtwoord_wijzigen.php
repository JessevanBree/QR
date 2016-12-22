<?php
	require_once("SQLi_wachtwoord_wijzigen.php");



?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ouderavond</title>
		<!-- Bootstrap core CSS -->
		<link href="../Bootstrap/css/bootstrap.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="style-aa.css" rel="stylesheet">
	</head>
    <body class="kleur-effect">
      <nav class="navbar">
		<div class="navbar-custom">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Ouderavond</a>
				</div>
			</div>
		</div>
    </nav>
        <div class="container">
            <div class="row">      
                <div class='col col-4'>
                    <div class='modal-dialog'>
                        <div class='modal-content bgcolor'>
                            <div class='modal-header'>
                                <h1 class='text-center'>Wachtwoord reset</h1>
                            </div>
                            <form action='' method='post'>
                                <div class='modal-body'>
                                    <div class='form-group'>
                                        <input type='text' name='inlog' placeholder='Gebruikersnaam' class='form-control input-lg'>
                                    </div>
									<div class='form-group'>
                                        <input type='password' name='wachtwoord' class='form-control input-lg' placeholder='Oud wachtwoord'/>
                                    </div>
                                    <div class='form-group'>
                                        <input type='password' name='wachtwoord_nieuw' class='form-control input-lg' placeholder='Nieuw wachtwoord'/>
                                    </div>
									<div class='form-group'>
                                        <input type='password' name='wachtwoord_check' class='form-control input-lg' placeholder='Herhaal nieuw Wachtwoord'/>
                                    </div>
                                    <div class='form-group'>									
                                        <Button type='submit' class='btn btn-block btn-lg btn-style'>
											<span class="glyphicon glyphicon-ok"></span> Bevestig
										</button>									
                                    </div>
                                </div>
                            </form>
							
							<?php
								//controleert of de post is geweest.
								if(isset($_POST["inlog"]) && isset($_POST["wachtwoord"]) && isset($_POST["wachtwoord_nieuw"]) && isset($_POST["wachtwoord_check"])){
									wachtwoord_wijzigen($_POST["inlog"], $_POST["wachtwoord"], $_POST["wachtwoord_nieuw"], $_POST["wachtwoord_check"]);
								}
							?>
                        </div>
                    </div>
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