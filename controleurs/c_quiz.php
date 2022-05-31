<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Gestion des quiz
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idSondage = filter_input(INPUT_GET, 'idSondage', FILTER_SANITIZE_STRING);
$lesQuestionsGenerales = $pdo->getLesQuestionsType(1, $idSondage);
$lesQuestionsDeSondage = $pdo->getLesQuestionsType(2, $idSondage);
switch ($action) {
    case "voirQuiz":
        include 'vues/v_quiz.php';
        break;
    case "creerQuestion":
        $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);
        $typeReponse = filter_input(INPUT_POST, 'lstTypeReponse', FILTER_SANITIZE_NUMBER_INT);
        $typeQuestion = filter_input(INPUT_POST, 'lstTypeQuestion', FILTER_SANITIZE_NUMBER_INT);
        $nombreCreation = filter_input(INPUT_POST, 'txtCreation', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->creeNouvelleQuestion($question, $typeQuestion, $typeReponse, $idSondage),
            'Cette question a bien été ajouté.',
            'Cette question n\'a pas pu être ajouté. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        $derniereQuestion = $pdo->derniereQuestion();
        for ($k = 1; $k < $nombreCreation + 1; $k++) {
            executeThenReturnMessage(
                $pdo->creeNouvelleReponse(filter_input(INPUT_POST, 'reponse' . $k, FILTER_SANITIZE_STRING), $derniereQuestion),
                'Cette réponse a bien été ajouté.',
                'Cette réponse n\'a pas pu être ajouté. Veuillez contacter l\'administrateur
                si ce problème persiste.'
            );
        }
        header('Location: index.php?uc=quiz&action=voirQuiz&idSondage=' . $idSondage);
        break;
    case "creerReponse":
        $numeroSondage = filter_input(INPUT_GET, 'numeroSondage', FILTER_SANITIZE_STRING);
        $numeroGeneral = filter_input(INPUT_GET, 'numeroGeneral', FILTER_SANITIZE_STRING);
        $idQuestion = filter_input(INPUT_GET, 'idQuestion', FILTER_SANITIZE_STRING);
        $btnGeneral = filter_input(INPUT_POST, 'btnGeneral', FILTER_SANITIZE_STRING);
        $btnSondage = filter_input(INPUT_POST, 'btnSondage', FILTER_SANITIZE_STRING);
        $nombreGeneral = filter_input(INPUT_POST, 'txtGeneral'.$numeroGeneral, FILTER_SANITIZE_STRING);
        $nombreSondage = filter_input(INPUT_POST, 'txtSondage'.$numeroSondage, FILTER_SANITIZE_STRING);
        if (isset($btnSondage)) {
            for ($i = 1; $i < $nombreSondage + 1; $i++) {
                executeThenReturnMessage(
                    $pdo->creeNouvelleReponse(filter_input(INPUT_POST, 'reponse' . $i, FILTER_SANITIZE_STRING), $idQuestion),
                    'Cette réponse a bien été ajouté.',
                    'Cette réponse n\'a pas pu être ajouté. Veuillez contacter l\'administrateur
                    si ce problème persiste.'
                );  
            }
        } else if (isset($btnGeneral)) {
            for ($j = 1; $j < $nombreGeneral + 1; $j++) {
                executeThenReturnMessage(
                    $pdo->creeNouvelleReponse(filter_input(INPUT_POST, 'reponse' . $j, FILTER_SANITIZE_STRING), $idQuestion),
                    'Cette réponse a bien été ajouté.',
                    'Cette réponse n\'a pas pu être ajouté. Veuillez contacter l\'administrateur
                    si ce problème persiste.'
                );
            }            
        }
        header('Location: index.php?uc=quiz&action=voirQuiz&idSondage=' . $idSondage);
        break;
    case "modifierQuestion":
        $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);
        $typeQuestion = filter_input(INPUT_POST, 'lstTypeQuestion', FILTER_SANITIZE_NUMBER_INT);
        $typeReponse = filter_input(INPUT_POST, 'lstTypeReponse', FILTER_SANITIZE_NUMBER_INT);
        $idQuestion = filter_input(INPUT_GET, 'idQuestion', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->modifierQuestion($idQuestion, $question, $typeQuestion, $typeReponse),
            'La question a bien été mis à jour.',
            'La question n\'a pas pu être mis à jour. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location: index.php?uc=quiz&action=voirQuiz&idSondage=' . $idSondage);
        break;
    case "modifierReponse":
        $idReponse = filter_input(INPUT_GET, 'idReponse', FILTER_SANITIZE_STRING);
        $reponse = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->modifierReponse($idReponse, $reponse),
            'La question a bien été mis à jour.',
            'La question n\'a pas pu être mis à jour. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location: index.php?uc=quiz&action=voirQuiz&idSondage=' . $idSondage);
        break;
    case "supprimerQuestion":
        $idQuestion = filter_input(INPUT_GET, 'idQuestion', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->supprimerReponses($idQuestion),
            'Ces réponses ont bien été supprimé.',
            'Ces réponses n\'ont pas pu être supprimé. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        executeThenReturnMessage(
            $pdo->supprimerQuestion($idQuestion),
            'Cette question a bien été supprimé.',
            'Cette question n\'a pas pu être supprimé. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location: index.php?uc=quiz&action=voirQuiz&idSondage=' . $idSondage);
        break;
    case "supprimerReponse":
        $idReponse = filter_input(INPUT_GET, 'idReponse', FILTER_SANITIZE_STRING);
        executeThenReturnMessage(
            $pdo->supprimerReponse($idReponse),
            'Cette réponse a bien été supprimé.',
            'Cette réponse n\'a pas pu être supprimé. Veuillez contacter l\'administrateur
            si ce problème persiste.'
        );
        header('Location: index.php?uc=quiz&action=voirQuiz&idSondage=' . $idSondage);
        break;
}


