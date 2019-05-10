<?php
// 1-Connexion à la DB
require '../kernel/db_connect.php';
// 2- Récupérer les données du form
require '../kernel/functions.php';
require '../models/user.php';
$fields_required = ['login','password'];
$datas_form = extractDatasForm($_POST,$fields_required);
$messages = [];
// 3- Vérifier que tous les champs sont remplis

if(in_array(null,$datas_form)) {
    $messages[]="Tous les champs sont obligatoires";
}
// 4-Lancer une requête SQL pour récupérer le user avec le login saisi
$user = findOneUserBy('login',$datas_form['login']);
if(count($user) != 1) {
    $messages[] = "impossible de vous identifier !";
}
//var_dump($user);
//die();

// 5- Comparé le mot de passe stocké ds la DB ou le mot de passe saisi par le user
//Saisi
else if(password_verify($datas_form['password'],$user[0]['password'])){
    //var_dump($user);
    //die();
    // 6- Si comparaison ok > is_admin  == 1 ??
    if($user[0]['is_admin'] == false) {
        $messages[] = "Vous n'avez pas le droit d'accéder";
    }else{
        // 7-Si user est admin > démarrage session, stockage ds la session d'une preuve d'identification
        session_start();
        $_SESSION["is_admin"] = true;
        $_SESSION['id_admin'] = $user[0]['id'];
        $_SESSION['login'] = $user[0]['login'];
        // 8- Redirection du user vers la page de gestion.php (page à créer)
        header('Location: ../backend/gestion.php');
        exit();
    }

}
else{
    $messages[] = "Votre mot de passe est erroné";
}






// Gestion des erreurs avec la variable $_SESSION['messages']
//On cumule les messages d'erreur et on redirige le user sur le form de login avec affichage de toutes ses erreurs
session_start();
$_SESSION['messages'] = $messages;
header('Location:../backend/index.php');