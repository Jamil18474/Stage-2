<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Index du projet Radio MODUL
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */
$racine = dirname(__FILE__);
require_once 'modeles/fct.inc.php';
require_once 'modeles/PdoRadioModul.inc.php';

session_start();

$pdo = PdoRadioModul::getPdoRadioModul();
$estConnecte = estConnecte();

require 'vues/v_entete.php';
require 'vues/v_menu.php';

//uc est la page qui sera présentée
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);

if (!$uc && !$estConnecte) { //si l'utilisateur n'est pas connecté
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}

switch (true) {
    case ($uc == 'connexion'):
        include $racine . '/controleurs/c_connexion.php';
        break;
    case ($uc == 'deconnexion' && $estConnecte):
        include $racine . '/controleurs/c_deconnexion.php';
        break;
    case ($uc == 'accueil' && $estConnecte):
        include $racine . '/controleurs/c_accueil.php';
        break;
    case ($uc == 'sondages' && $estConnecte):
        include $racine . '/controleurs/c_sondages.php';
        break;
    case ($uc == 'sondage' && $estConnecte):
        include $racine . '/controleurs/c_sondage.php';
        break;
    case ($uc == 'quiz' && $estConnecte):
        include $racine . '/controleurs/c_quiz.php';
        break;
    case ($uc == 'musiques' && $estConnecte):
        include $racine . '/controleurs/c_musiques.php';
        break;
    case ($uc == 'test'):
        include $racine . '/controleurs/c_test.php';
        break;
    case ($uc == 'stats' && $estConnecte):
        include $racine . '/controleurs/c_stats.php';
        break;
}

require 'vues/v_pied.php';
