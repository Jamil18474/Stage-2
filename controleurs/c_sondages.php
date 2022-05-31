<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Gestion de l'affichage des sondages
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$lesSondages = $pdo->getLesSondages(false);
$idSondage = filter_input(INPUT_GET, 'idSondage', FILTER_SANITIZE_STRING);
$archive = 0;
switch ($action) {   
    case 'activerSondage':
        executeThenReturnMessage(
            $pdo->activerSondage($idSondage, true),
            'Ce sondage a bien été activé.',
            'Erreur: ce sondage n\'a pas pu être activé. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        $lesSondages = $pdo->getLesSondages(false);
        break;
    case 'archiverSondage':
        executeThenReturnMessage(
            $pdo->archiverSondage($idSondage, true),
            'Ce sondage a bien été archivé.',
            'Erreur: ce sondage n\'a pas pu être archivé. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        $lesSondages = $pdo->getLesSondages(false);
        break;
    case 'rechercherSondages':
        $valeur = filter_input(INPUT_POST, 'txtRecherche', FILTER_SANITIZE_STRING);
        $archive = filter_input(INPUT_GET, 'archive', FILTER_SANITIZE_STRING);
        if($archive == 0) {
            $lesSondages = $pdo->getLesSondagesRecherche($valeur, false);
        } else {
            $lesSondages = $pdo->getLesSondagesRecherche($valeur, true);
        }
        break;
    case 'voirArchives':
        $archive = 1;
        $lesSondages = $pdo->getLesSondages(true);
        break;
}
require $racine.'/vues/v_sondages.php';
