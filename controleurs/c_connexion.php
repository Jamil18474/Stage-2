<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


/**
 * Gestion de la connexion
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include $racine.'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $admin = $pdo->getInfosAdmin($login, $mdp);
    if (!is_array($admin)) {
        ajouterErreur('Login ou mot de passe incorrect');
        include $racine.'/vues/v_erreurs.php';
        include $racine.'/vues/v_connexion.php';
    } else {
        $id = $admin['id'];
        $nom = $admin['nom'];
        $prenom = $admin['prenom'];
        connecter($id, $nom, $prenom);
        if (headers_sent()) {
            die("Redirection échouée: <a href=\"\index.php\">Cliquer ici</a>");
        }
        else{
            exit(header('Location: index.php'));
        }
    }
    break;
default:
    include $racine.'/vues/v_connexion.php';
    break;
}
