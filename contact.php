<?php

$msg = $class = $nom = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $class = "erreur";
    $msg = "Le formulaire doit être soumis avec la méthode POST !";
}

if($msg == ""){
    if(!isset($_POST["submit"])){
        $class = "erreur";
        $msg = "Le formulaire doit être soumis en cliquant sur le bouton <Envoyer> !";
    }
}

if($msg == ""){
    if (empty($_POST["nom"])) {
        $msg= "Le nom est requis";
        $class= "erreur";
    } else {
        $nom = nettoyer_donnee($_POST["nom"]);
    }    
}

if($msg == ""){
    if (empty($_POST["email"])) {
        $class = "erreur";
        $msg = "L'email est requis";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $class = "erreur";
        $msg = "Format d'email invalide";
    } else {
        $email = nettoyer_donnee($_POST["email"]);
    }
}

if($msg == ""){
    if (empty($_POST["message"])) {
        $class = "erreur";
        $msg = "Le message est requis";
    } else {
        $message = nettoyer_donnee($_POST["message"]);
    }    
}


// MAIL
// configuration de php.ini et sendmail.ini pour envoi mails en gmail.com
// tests avec MailHog
// 

if($msg == ""){
    $destinataire= "lucemmthi@gmail.com";
    $sujet = "Sujet de l'email";
    // contenu au format HTML
    $contenu = "<html><body><p>$nom</p><p>$email</p><p>$message</p></body></html";
    
    //$headers = "From: $destinataire \n" ;
    
    // $sended = mail($destinataire, $sujet, $contenu, $headers);
    $sended = mail($destinataire, $sujet, $contenu);
    if($sended){
        $class = "succes";
        $msg= "Votre message a été envoyé avec succès.";
    }else{
        $class = "erreur";
        $msg= "L'envoi de votre message a échoué.";
    }
    
}

// FONCTIONS

function nettoyer_donnee($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact</title>
</head>
<body>
    <div class="container">
        <p class="<?= $class ?>"><?= $msg ?></p>
        <a href="index.html">Retour au formulaire</a>
    </div>

</body>
</html>