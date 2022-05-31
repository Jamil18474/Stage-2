<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


/**
 * Vue Statistiques des Musiques
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

?>

<a href="index.php?uc=sondages"
   class="btn btn-primary" role="button">
    <br>Retour à la liste des sondages</a>

<div class="panel-body">
    <div class="col-xs-offset-5">
        <a href="index.php?uc=stats&action=statsMusiques&idSondage=<?php echo $idSondage ?>"
           class="btn btn-primary" role="button">
            <br>Stats des musiques</a>
    </div>
    <div class="col-xs-offset-5">
        <a href="index.php?uc=stats&action=statsQuiz&idSondage=<?php echo $idSondage ?>"
           class="btn btn-primary" role="button">

            <br>Stats des réponses</a>
    </div>
</div>
<?php
if (isset($lesMusiques)) {
    foreach ($lesMusiques as $uneMusique) {
        ?> <div class="card">
            <h4 class="card-header"> <?php echo $uneMusique['titre'] ?></h4>
        <?php
        $scoreadorer = $uneMusique['scoreadorer'];
        $scoreaimer = $uneMusique['scoreaimer'];
        $scoredetester = $uneMusique['scoredetester'];
        $scoreinconnu = $uneMusique['scoreinconnu'];
        $scorerepetitif = $uneMusique['scorerepetitif'];
        $total = $scoreadorer + $scoreaimer + $scoredetester + $scoreinconnu + $scorerepetitif;
        $coefficient = 100;
        if ($total == 0) {
            echo "0%";
        } else {
            echo pourcentage($scoreadorer, $total, $coefficient) . " % ont adoré cette musique.";
            echo "<br>";
            echo pourcentage($scoreaimer, $total, $coefficient) . " % ont aimé cette musique.";
            echo "<br>";
            echo pourcentage($scoredetester, $total, $coefficient) . " % n'ont pas aimé cette musique.";
            echo "<br>";
            echo pourcentage($scoreinconnu, $total, $coefficient) . " % ne connaissent pas cete musique.";
            echo "<br>";
            echo pourcentage($scorerepetitif, $total, $coefficient) . " % ont trop entendu cette musique.";
        }
    }
}