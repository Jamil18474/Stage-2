<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


/**
 * Vue Statistiques des Quiz
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
if (isset($lesQuestionsGenerales)) {
    foreach ($lesQuestionsGenerales as $uneQuestionGenerale) {
        ?> 
        <h4 class="card-header"> <?php echo $uneQuestionGenerale['questionlibelle'] ?></h4>
        <?php
        $lesReponsesGenerales = $pdo->getLesReponses($uneQuestionGenerale['id']);
        $total = $pdo->getTotalScoreReponses($uneQuestionGenerale['id']);
        foreach ($lesReponsesGenerales as $uneReponseGenerale) {
            $score = $uneReponseGenerale['score'];
            $coefficient = 100;
            if ($total == 0) {
                echo "0%";
            } else {
                echo pourcentage($score, $total, $coefficient) . " % ont voté " . $uneReponseGenerale['reponselibelle'];
            }
            echo "<br>";
        }
    }
}
if (isset($lesQuestionsDeSondage)) {
    foreach ($lesQuestionsDeSondage as $uneQuestionDeSondage) {
        ?> 
        <h4 class="card-header"> <?php echo $uneQuestionDeSondage['questionlibelle'] ?></h4>
        <?php
        $lesReponsesDeSondage = $pdo->getLesReponses($uneQuestionDeSondage['id']);
        $total = $pdo->getTotalScoreReponses($uneQuestionDeSondage['id']);
        foreach ($lesReponsesDeSondage as $uneReponseDeSondage) {
            $score = $uneReponseDeSondage['score'];
            $coefficient = 100;
            if ($total == 0) {
                echo "0%";
            } else {
                echo pourcentage($score, $total, $coefficient) . " % ont voté " . $uneReponseDeSondage['reponselibelle'];
            }
            echo "<br>";
        }
    }
}