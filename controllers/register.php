<?php
// Etape 1 > connexion à la base de données
require '../kernel/db_connect.php';
// Etape 2 > récupérer les données du formulaire
require '../kernel/functions.php';
require '../models/user.php';
$fields_required = ['login','password','email','nom','prenom'];
$datas_form = extractDatasForm($_POST,$fields_required);
//var_dump($datas_form);
// Etape 3 > vérifier que tous les champs sont remplis
$messages = [];
if(in_array(null,$datas_form)){
    $messages[] = "tous les champs sont obligatoires";
}
// Etape 4-a > Vérifier le format de l'email
if(filter_var($datas_form['email'],FILTER_VALIDATE_EMAIL) == false){
    $messages[] = "Votre email est invalide";
}

// Etape 4 > vérifier que le login est unique (pas déjà ds la DB)
$resultat = findOneUserBy('email',$datas_form['email']);
//echo count($resultat);
$nb_emails = count($resultat);
if($nb_emails >0) {
    $messages[] = "un utilisateur  est déjà inscrit avec cet email.Peut-être,avez-vous déjà un compte?";
}

//$messages[] ="votre login est déjà pris";

//Fixture


//Etape 5 > vérifier que login est unique ----
$res_login = findOneUserBy('login',$datas_form['login']);
$nb_logins = count($res_login);
if($nb_logins>0) {
    $messages[] = "cet utilsateur existe déjà.";
}
// ----- 6 ------ que le mot de passe fait aumoins 8 caractères

if(strlen($datas_form["password"]) <8) {
    $messages[]= "Ce mot de passe est trop court";
}
//-------7 si tout est ok > insertion des datas dans la db > redirection vers la page confirmation inscription
if(count($messages) == 0){
    //Exécuter une requête SQL pour transferer les données saisies dans le form ds la base de données.
    addUser($datas_form);

    //Démarrage de session
    session_start();
    //On stocke ds la sesssion une donnée "preuve"
    $_SESSION['is_inscrit'] = true;

    header('Location:../confirmation.php');
    exit();
}

//En général > gestion des erreurs: quand un/ ou n problèmes se déclenchent, afficher tous les messages d'erreurs en mm temps sue la page d'inscription

//démarrage session poue stocker les msg d'erreur
session_start();
$_SESSION['messages'] = $messages;
header('Location:../index.php');