<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Consultation des statistiques des musiques et des quiz
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
    case "statsMusiques":
        $lesMusiques = $pdo->getLesMusiques($idSondage);
        include 'vues/v_statsMusiques.php';
        break;
    case "statsQuiz":
        $lesQuestionsGenerales = $pdo->getLesQuestionsType(1, $idSondage);
        $lesQuestionsDeSondage = $pdo->getLesQuestionsType(2, $idSondage);
        include 'vues/v_statsQuiz.php';
        break;
}