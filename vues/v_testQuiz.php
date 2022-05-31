<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


/**
 * Vue Test des Quiz
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

?>


<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=test&action=majScoreReponse&idSondage=<?php echo $idSondage ?>&adresseIp=<?php echo $adresseIp ?>" 
              method="post" role="form">
            <br>Questions générales
<?php

foreach ($lesQuestionsGenerales as $uneQuestionGenerale) {
    ?> <div class="card">
                    <h4 class="card-header"> <?php echo $uneQuestionGenerale['questionlibelle']; ?></h4>

                <?php
                $lesReponsesGenerales = $pdo->getLesReponses($uneQuestionGenerale['id']);
                foreach ($lesReponsesGenerales as $uneReponseGenerale) {
                    ?>
                        <div class="card-body">
                    <?php if ($uneQuestionGenerale['idtypereponse'] == 1) { ?>
                                <input type="radio"  name="reponse[<?php echo $uneReponseGenerale['idquestion'] ?>]" value="<?php echo $uneReponseGenerale['id'] ?>" required>
            <?php
        } else {
            ?>
                                <input type="checkbox" name="reponse[]" value="<?php echo $uneReponseGenerale['id'] ?>">
                            <?php
                        }echo $uneReponseGenerale['reponselibelle'];
                        ?>
                        </div>         
                        <?php
                    }
                }
                ?>
                <br>Questions de Sondage
                    <?php
                    
                    foreach ($lesQuestionsDeSondage as $uneQuestionDeSondage) {
                        ?> <div class="card">
                        <h4 class="card-header"> <?php echo $uneQuestionDeSondage['questionlibelle']; ?></h4>
                        <?php
                        $lesReponsesDeSondage = $pdo->getLesReponses($uneQuestionDeSondage['id']);
                        foreach ($lesReponsesDeSondage as $uneReponseDeSondage) {
                            ?>
                            <div class="card-body">
                        <?php if ($uneQuestionDeSondage['idtypereponse'] == "une") { ?>
                                    <input type="radio"  name="reponse[<?php echo $uneReponseDeSondage['idquestion'] ?>]" value="<?php echo $uneReponseDeSondage['id'] ?>"required>
                            <?php
                        } else {
                            ?>
                                    <input  type="checkbox" name="reponse[]" value="<?php echo $uneReponseDeSondage['id'] ?>">
                            <?php
                        }echo $uneReponseDeSondage['reponselibelle'];
                        ?>
                            </div>         
                        <?php
                    }
                }
                ?>
                    <button class="btn btn-success" type="submit">Enregistrer </button>
                </div>
            </div>
        </form>
    </div>
</div>