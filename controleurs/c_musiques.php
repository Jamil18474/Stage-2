<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Gestion des musiques
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idSondage = filter_input(INPUT_GET, 'idSondage', FILTER_SANITIZE_STRING);
switch ($action) {
    case "voirMusiques":
        $lesMusiques = $pdo->getLesMusiques($idSondage);
        include 'vues/v_musiques.php';
        break;
    case "creerMusique":
        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
        $audio = $_FILES['audio']['name'];
        $tmpaudio = $_FILES['audio']['tmp_name'];
        if (!file_exists("audio")) {
            mkdir("audio");
        }
        move_uploaded_file($tmpaudio, "audio/" . $audio);
        executeThenReturnMessage(
            $pdo->creeNouvelleMusique($titre, $audio, $idSondage),
            'Cette musique a bien été ajouté.',
            'Cette musique n\'a pas pu être ajouté. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location:index.php?uc=musiques&action=voirMusiques&idSondage=' . $idSondage);
        break;
    case "modifierTitre":
        $idMusique = filter_input(INPUT_GET, 'idMusique', FILTER_SANITIZE_STRING);
        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->modifierTitre($idMusique, $titre),
            'Le titre de la musique a bien été mis à jour.',
            'Le titre de la musique n\'a pas pu être mis à jour. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location:index.php?uc=musiques&action=voirMusiques&idSondage=' . $idSondage);
        break;
    case "modifierAudio":
        $idMusique = filter_input(INPUT_GET, 'idMusique', FILTER_SANITIZE_STRING);
        $audio = filter_input(INPUT_POST, 'audio', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->modifierAudio($idMusique, $audio),
            'L\'audio a bien été mis à jour.',
            'L\'audio n\'a pas pu être mis à jour. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location:index.php?uc=musiques&action=voirMusiques&idSondage=' . $idSondage);
        break;
    case "supprimerMusique":
        $idMusique = filter_input(INPUT_GET, 'idMusique', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->supprimerMusique($idMusique),
            'Cette musique a bien été supprimé.',
            'Cette musique n\'a pas pu être supprimé. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location:index.php?uc=musiques&action=voirMusiques&idSondage=' . $idSondage);
        break;
}

