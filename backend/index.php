<?php
session_start();
//print_r($_SESSION);
require "../kernel/functions.php";
require 'templates/header.php';
?>


<body>
<div class="container">

    <div class="row">
        <div class="col-6 offset-3">
            <h1>Identifiez-vous !</h1>
            <?= getFlash() ?>
            <form action="../controllers/login.php" method="POST">
               <div class="form-group">
                   <label for="login">Votre login</label>
                   <input class="form-control" type="text" name="login" id="login">
               </div>
                <div class="form-group">
                    <label for="password">Votre mot de passe</label>
                    <input class="form-control" type="password" name="password"  id="password">
                    <div class="form-group text-right">
                      <input type="submit" class="btn btn-primary" value="se connecter">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require 'templates/footer.php'?>
</body>
</html>