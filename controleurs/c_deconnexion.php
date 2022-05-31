<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Gestion de la déconnexion
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (estConnecte()) {
    $uc = 'demandeconnexion';
}
switch ($action) {
case 'demandeDeconnexion':
    include 'vues/v_deconnexion.php';
    break;
case 'valideDeconnexion':
    if (estConnecte()) {
        include 'vues/v_deconnexion.php';
    } else {
        ajouterErreur("Vous n'êtes pas connecté");
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    }
    break;
default:
    include 'vues/v_connexion.php';
    break;
}
