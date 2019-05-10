<?php
// Récupérer la session
session_start();
//Vérifier la preuve d'identification et d'autorisation
if(isset($_SESSION['is_admin'])== false) {
    $_SEESION['messages'] = ['Accès interdit'];
    header('Location: ../backend/index.php');
    exit();
}
//redirection vers page login si pas autorisé