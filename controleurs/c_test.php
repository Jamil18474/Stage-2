<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Gestion du test
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
    case "test":
        $adresseIp = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        $lesQuestionsGenerales = $pdo->getLesQuestionsType(1, $idSondage);
        $lesQuestionsDeSondage = $pdo->getLesQuestionsType(2, $idSondage);
        $lesIpFini = $pdo->getLesIpFini(true, $idSondage);
        $lesIp = $pdo->getLesIp($idSondage);
        if (!in_array($adresseIp, $lesIp)) {
            executeThenReturnMessage(
                $pdo->creeNouvelleAdresseIp($adresseIp, $idSondage),
                'Cette adresseIP a bien été ajouté.',
                'Erreur: cette adresseIP n\'a pas pu être ajouté. Veuillez contacter l\'administrateur
                si ce problème persiste.'
            );
            include 'vues/v_testQuiz.php';
      
        } elseif (in_array($adresseIp, $lesIpFini)) {
            ajouterErreur("Vous avez déjà participé à ce sondage");
            include 'vues/v_erreurs.php';
         
        } else {
            include 'vues/v_testQuiz.php';
        }
        break;
    case "majScoreReponse":
        $adresseIp = filter_input(INPUT_GET, 'adresseIp', FILTER_SANITIZE_STRING);
        $score = 0;
        $lesReponses = array();
        foreach ($_POST['reponse'] as $idReponse) {
            if (isset($idReponse)) {
                $lesIdReponses[] = $idReponse;
                $pdo->majScoreReponse($idReponse);
            }
        }
        $lesQuestionsCochees = $pdo->getLesIdQuestionsCochees($idSondage);
        foreach ($lesQuestionsCochees as $uneQuestioncochee) {
            $lesIdReponsesCochees = $pdo->getLesIdReponses($uneQuestioncochee);
            foreach ($lesIdReponses as $unIdReponse) {
                if (in_array($unIdReponse, $lesIdReponsesCochees)) {
                    $score++;
                    break;
                }
            }
        }
        if ($score != count($lesQuestionsCochees)) {
            ajouterErreur("Au moins une checkbox doit être cochée");
            include 'vues/v_erreurs.php';
            include 'vues/v_testQuiz.php';

        } else {
            $lesAudios = $pdo->getLesAudios($idSondage);
            $lesIdMusiques = $pdo->getLesIdMusiques($idSondage);
            include 'vues/v_testEcoute.php';
        }
        break;

    case "majScoreMusique":
        $idMusique = filter_input(INPUT_POST, 'idMusique', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
        if ($type == 1) {
            executeThenReturnMessage(
                    $pdo->majScoreAdorer($idMusique),
                    'Le score de l\'appréciation "adorer" a bien augmenté de 1.',
                    'Erreur: L\'appréciation "adorer" n\'a pas augmenté de 1. Veuillez contacter l\'administrateur
                     si ce problème persiste.'
            );
        } elseif ($type == 2) {
            executeThenReturnMessage(
                    $pdo->majScoreAimer($idMusique),
                    'Le score de l\'appréciation "aimer" a bien augmenté de 1.',
                    'Erreur: L score de l\'appréciation "aimer" n\'a pas augmenté de 1. Veuillez contacter l\'administrateur
                     si ce problème persiste.'
            );
        } elseif ($type == 3) {
            executeThenReturnMessage(
                    $pdo->majScoreDetester($idMusique),
                    'Le score de l\'appréciation "detester" a bien augmenté de 1.',
                    'Erreur: L\'appréciation "detester" n\'a pas augmenté de 1. Veuillez contacter l\'administrateur
                     si ce problème persiste.'
            );
        } elseif ($type == 4) {
            executeThenReturnMessage(
                    $pdo->majScoreInconnu($idMusique),
                    'Le score de l\'appréciation "inconnu" a bien augmenté de 1.',
                    'Erreur: L\'appréciation "inconnu" n\'a pas augmenté de 1. Veuillez contacter l\'administrateur
                     si ce problème persiste.'
            );
        } elseif ($type == 5) {
            executeThenReturnMessage(
                    $pdo->majScoreRepetitif($idMusique),
                    'L\'appréciation "repetitif" a bien augmenté de 1.',
                    'Erreur: L\'appréciation "repetitif" n\'a pas augmenté de 1. Veuillez contacter l\'administrateur
                     si ce problème persiste.'
            );
        }
        break;
    case"voirMessage":
        $idSondage = filter_input(INPUT_GET, 'idSondage', FILTER_SANITIZE_STRING);
        $sondage = $pdo->getSondage($idSondage);
        $adresseIp = filter_input(INPUT_GET, 'adresseIp', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
                $pdo->majFiniIp($adresseIp, true, $idSondage),
                'L\'utilisateur qui possède cette adresseIP a bien fini le sondage.',
                'Erreur: l\'utilisateur qui possède cette adresseIP n\'a pas fini le sondage. Veuillez contacter l\'administrateur
                si ce problème persiste.'
        );
        include 'vues/v_message.php';
        break;
}