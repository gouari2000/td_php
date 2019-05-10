<?php
//Récupérer session
session_start();
//bdestruction session
session_destroy();
//redirection vers page login
header('Location: ../backend/index.php');
exit();