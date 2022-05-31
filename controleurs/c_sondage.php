<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Gestion des sondages
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idSondage = filter_input(INPUT_GET, 'idSondage', FILTER_SANITIZE_STRING);
$sondage = $pdo->getSondage($idSondage);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
$societe = filter_input(INPUT_POST, 'societe', FILTER_SANITIZE_STRING);
$dateDeDebut = filter_input(INPUT_POST, 'dateDeDebut', FILTER_SANITIZE_STRING);
$heureDeDebut = filter_input(INPUT_POST, 'heureDeDebut', FILTER_SANITIZE_STRING);
$dateDeFin = filter_input(INPUT_POST, 'dateDeFin', FILTER_SANITIZE_STRING);
$heureDeFin = filter_input(INPUT_POST, 'heureDeFin', FILTER_SANITIZE_STRING);
$texteDeFin = filter_input(INPUT_POST, 'texteDeFin', FILTER_SANITIZE_STRING);
switch ($action) {
    case 'voirCreationSondage':
        include 'vues/v_creationSondage.php';
        break;
    case 'creerSondage':
        valideInfosSondage($dateDeDebut, $dateDeFin, $heureDeFin);
        if (nbErreurs() > 0) {
            include $racine.'/vues/v_erreurs.php';
            include $racine.'/vues/v_creationSondage.php';
        } else {
        $creerSondage = $pdo->creeNouveauSondage(
            $societe, 
            $nom, 
            $dateDeDebut, 
            $heureDeDebut, 
            $dateDeFin, 
            $heureDeFin, 
            $texteDeFin
            );
        executeThenReturnMessage(
            $creerSondage,
            'Ce sondage a bien été ajouté.',
            'Ce sondage n\'a pas pu être ajouté. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
            include $racine.'/vues/v_creationSondage.php';
        }
        break;
    case 'voirModificationSondage':
        include 'vues/v_modificationSondage.php';
        break;
    case 'modifierSondage':
        valideInfosSondage($dateDeDebut, $dateDeFin, $heureDeFin);
        if (nbErreurs() > 0) {
            include $racine.'/vues/v_erreurs.php';
        } else {
        executeThenReturnMessage(
            $pdo->modifierSondage($idSondage, $societe, $nom, $dateDeDebut, $heureDeDebut, $dateDeFin, $heureDeFin, $texteDeFin),
            'Le sondage a bien été mis à jour.',
            'Le sondage n\'a pas pu être mis à jour. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );    
            header('Location:index.php?uc=sondage&action=voirModificationSondage&idSondage=' . $idSondage);
        }
        break;
}
