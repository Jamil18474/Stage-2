<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Fonctions pour le site web Radio MODUL
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

/**
 * Teste si un administrateur est connecté
 *
 * @return vrai ou faux
 */
function estConnecte() {
    return isset($_SESSION['idAdmin']);
}

/**
 * Enregistre dans une variable session les infos d'un utilisateur
 *
 * @param String $idAdmin    ID de l'administrateur
 * @param String $nom       Nom de l'administrateur
 * @param String $prenom    Prénom de l'administrateur
 *
 * @return null
 */
function connecter($idAdmin, $nom, $prenom) {
    $_SESSION['idAdmin'] = $idAdmin;
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
}

/**
 * Détruit la session active
 *
 * @return null
 */
function deconnecter() {
    session_destroy();
}

/**
 *  Retourne les lignes du fichier texte contenant les informations de connexion
 * 
 * @return String Les lignes du fichier texte 
 */
function getLines() {
    $lines = "";
    $file = fopen("security/config.txt", "r");
    while (!feof($file)) {
        $lines .= fgets($file);
    }
    $members = explode("\n", $lines);
    fclose($file);
    return $members;
}

/**
* Ajoute un message d'erreur ou de succès suivant le retour de la fonction test.
* Si la fonction test retourne vrai, on considère que c'est un succès et on ajoute
* le message de succès. Le cas échant, on ajoute le message d'erreurs. Les messages
* sont passés en paramètre.
*
* @param Boolean $test      La fonction à tester
* @param String $successMsg Le message de succès à ajouter
* @param String $errorMsg   Le message d'erreur à ajouter
* @return null
*/
function executeThenReturnMessage($test, $successMsg, $errorMsg){
    if($test){
        ajouterSucces($successMsg);
        include 'vues/v_succes.php';
    } else {
        ajouterErreur($errorMsg);
        include 'vues/v_erreurs.php';
    }
}

/**
 * Ajoute le libellé d'une erreur au tableau des erreurs
 *
 * @param String $msg Libellé de l'erreur
 *
 * @return null
 */
function ajouterErreur($msg) {
    if (!isset($_REQUEST['erreurs'])) {
        $_REQUEST['erreurs'] = array();
    }
    $_REQUEST['erreurs'][] = $msg;
}

/**
 * Ajoute le libellé d'un succès au tableau des succès
 *
 * @param String $msg Libellé du succès
 *
 * @return null
 */
function ajouterSucces($msg)
{
    if (!isset($_REQUEST['succes'])) {
        $_REQUEST['succes'] = array();
    }
    $_REQUEST['succes'][] = $msg;
}

/**
 * Retoune le nombre de lignes du tableau des erreurs
 *
 * @return Integer le nombre d'erreurs
 */
function nbErreurs() {
    if (!isset($_REQUEST['erreurs'])) {
        return 0;
    } else {
        return count($_REQUEST['erreurs']);
    }
}

/**
 * Retourne le pourcentage d'un nombre
 * 
 * @param Integer $nombre
 * @param Integer $total
 * @param Integer $coefficient
 * 
 * @return Float le pourcentage 
 */
function pourcentage($nombre, $total, $coefficient) {
    $resultat = ($nombre / $total) * $coefficient;
    return round($resultat);
}

/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa
 *
 * @param String $date Date à tester
 *
 * @return Boolean vrai ou faux
 */
function estDateValide($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
 * Vérifie la validité des trois arguments : la date de début, la date de fin
 * et l'heure de fin du sondage
 *
 * Des message d'erreurs sont ajoutés au tableau des erreurs
 *
 * @param String $datededebut Date de début du sondage
 * @param String $datedefin Date de fin du sondage  
 * @param String  $heuredefin Heure de fin du sondage
 *
 * @return Boolean vrai ou faux
 */
function valideInfosSondage($datededebut, $datedefin, $heuredefin) {
    if (!estDatevalide($datededebut) || !estDateValide($datedefin)) {
        ajouterErreur('Date invalide');
    }
    if (!valideDate($datedefin, $heuredefin)) {
        ajouterErreur('la date ne doit pas être inférieure à la date actuelle');
    }
    if ($datededebut > $datedefin) {
        ajouterErreur('La date de début ne doit pas être supérieure à la date de fin');
    }
}

/**
 * Vérifie la validité des deux arguments : la date de fin et l'heure de fin du sondage
 *
 * @param String $datedefin Date de fin du sondage  
 * @param Float  $heuredefin Heure de fin du sondage
 *
 * @return 
 */
function valideDate($datedefin, $heuredefin) {
    $boolReturn = true;
    $date = $datedefin . " " . $heuredefin;
    if ($date < date('Y-m-d h:i:s')) {
        $boolReturn = false;
    }
    return $boolReturn;
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 *
 * @param Array $tabEntiers Un tableau d'entier
 *
 * @return Boolean vrai ou faux
 */
function estTableauEntiers($tabEntiers) {
    $boolReturn = true;
    foreach ($tabEntiers as $unEntier) {
        if (!estEntierPositif($unEntier)) {
            $boolReturn = false;
        }
    }
    return $boolReturn;
}

/**
 * Indique si une valeur est un entier positif ou nul
 *
 * @param Integer $valeur Valeur
 *
 * @return Boolean vrai ou faux
 */
function estEntierPositif($valeur) {
    return preg_match('/[^0-9]/', $valeur) == 0;
}
