<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


/**
 * Gestion de l'accueil
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */
if ($estConnecte) {
    include $racine . '/vues/v_accueil.php';
} else {
    include $racine . '/vues/v_connexion.php';
}
