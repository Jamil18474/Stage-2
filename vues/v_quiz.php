<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Liste Quiz : Gère l'affichage des quiz
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */
?>
<div>
    <a href="index.php?uc=sondages"
       class="btn btn-primary" role="button">
        <br>Retour à la liste des sondages</a>
</div>
<br>Quiz généraux
<?php
$numeroGeneral = 0;
if (isset($lesQuestionsGenerales)) {
    foreach ($lesQuestionsGenerales as $uneQuestionGenerale) {
        $questionlibelle = $uneQuestionGenerale['questionlibelle'];
        $idQuestion = $uneQuestionGenerale['id'];
        $idtypereponse = $uneQuestionGenerale['idtypereponse'];
        ?>
        <form action="index.php?uc=quiz&action=modifierQuestion&idSondage=<?php echo $idSondage ?>&idQuestion=<?php echo $idQuestion ?>" 
              method="post" role="form">
            <label for="question">Titre:</label>
            <input type = "text" id="question" name="question" value = "<?php echo $questionlibelle ?>" required>                  
            <label for="lstTypeQuestion">Type de question :</label>
            <select id="lstTypeQuestion"  name="lstTypeQuestion" class="form-control">
                <option selected value="1">general</option>
                <option value="2">sondage</option>
            </select>
            <label for="lstTypeReponse">Type de réponse :</label>
            <select id="lstTypeReponse"  name="lstTypeReponse" class="form-control">
        <?php if ($idtypereponse == 1) { ?>
                    <option selected value="1">une</option>
                    <option value="2">plusieurs</option>
                <?php } else { ?>
                    <option value="1">une</option>
                    <option selected value="2">plusieurs</option>
                <?php } ?>
            </select>  
            <button  class="btn btn-success" type="submit" >Enregistrer la question</button>
        </form>
        <form action="index.php?uc=quiz&action=supprimerQuestion&idSondage=<?php echo $idSondage ?>&idQuestion=<?php echo $idQuestion ?>" 
              method="post" role="form">
            <button class="btn btn-success" type="submit" >Supprimer la question</button>
        </form>
        <?php
        $lesReponsesGenerales = $pdo->getLesReponses($idQuestion);
        foreach ($lesReponsesGenerales as $uneReponseGenerale) {
            $reponselibelle = $uneReponseGenerale['reponselibelle'];
            $idReponse = $uneReponseGenerale['id'];
            ?>
            <form action="index.php?uc=quiz&action=modifierReponse&idSondage=<?php echo $idSondage ?>&idReponse=<?php echo $idReponse ?>"
                  method="post" role="form">
                <label for="reponse">Reponse:</label>
                <input type = "text" id="reponse" name="reponse" value = "<?php echo $reponselibelle ?>" required >
                <button class="btn btn-success" type="submit" >Enregistrer la réponse</button>
            </form>
            <form action="index.php?uc=quiz&action=supprimerReponse&idSondage=<?php echo $idSondage ?>&idReponse=<?php echo $idReponse ?>"
                  method="post" role="form">
                <button class="btn btn-success" type="submit" >Supprimer la réponse</button>
            </form>
        <?php }$numeroGeneral++; ?>
        <form action="index.php?uc=quiz&action=creerReponse&idSondage=<?php echo $idSondage ?>&idQuestion=<?php echo $idQuestion ?>&numeroGeneral=<?php echo $numeroGeneral ?>"
              method="post" role="form">
            <input type="hidden" name = "txtGeneral<?php echo $numeroGeneral ?>" id="txtGeneral<?php echo $numeroGeneral ?>" value="0">
            <input type="button" id="bouton" value="Ajouter une réponse" onclick = 'creerReponse("General", "<?php echo $numeroGeneral; ?>");'>
            <input type="button" id="bouton" value="Supprimer une réponse" onclick = 'supprimerReponse("General", "<?php echo $numeroGeneral; ?>");'> 
            <div id="champsGeneral<?php echo $numeroGeneral ?>">
            </div>
            <button name = "btnGeneral" class="btn btn-success" type="submit" >Enregistrer la ou les réponse(s)</button>
        </form>
    <?php
    }
}
?>
<br>Quiz de sondage
<?php
$numeroSondage = 0;
if (isset($lesQuestionsDeSondage)) {
    foreach ($lesQuestionsDeSondage as $uneQuestionDeSondage) {
        $questionlibelle = $uneQuestionDeSondage['questionlibelle'];
        $idQuestion = $uneQuestionDeSondage['id'];
        $idtypereponse = $uneQuestionDeSondage['idtypereponse'];
        ?>
        <form action="index.php?uc=quiz&action=modifierQuestion&idSondage=<?php echo $idSondage ?>&idQuestion=<?php echo $idQuestion ?>" 
              method="post" role="form">
            <label for="question">Titre:</label>
            <input type = "text" id="question" name="question" value = "<?php echo $questionlibelle ?>" required>
            <label for="lstTypeQuestion">Type de question :</label>
            <select id="lstTypeQuestion"  name="lstTypeQuestion" class="form-control">
                <option value="1">general</option>
                <option selected value="2">sondage</option>
            </select>
            <label for="lstTypeReponse">Type de réponse :</label>
            <select id="lstTypeReponse"  name="lstTypeReponse" class="form-control">
        <?php if ($idtypereponse == 1) { ?>
                    <option selected value="1">une</option>
                    <option value="2">plusieurs</option>
        <?php } else { ?>
                    <option value="1">une</option>
                    <option selected value="2">plusieurs</option>
        <?php } ?>
            </select>  
            <button  class="btn btn-success" type="submit" >Enregistrer la question</button>  
        </form>
        <form action="index.php?uc=quiz&action=supprimerQuestion&idSondage=<?php echo $idSondage ?>&idQuestion=<?php echo $idQuestion ?>" 
              method="post" role="form">
            <button class="btn btn-success" type="submit" >Supprimer la question</button>
        </form>
        <?php
        $lesReponsesDeSondage = $pdo->getlesReponses($idQuestion);
        foreach ($lesReponsesDeSondage as $uneReponseDeSondage) {
            $reponselibelle = $uneReponseDeSondage['reponselibelle'];
            $idReponse = $uneReponseDeSondage['id'];
            ?>
            <form action="index.php?uc=quiz&action=modifierReponse&idSondage=<?php echo $idSondage ?>&idReponse=<?php echo $idReponse ?>"
                  method="post" role="form">
                <label for="reponse">Reponse:</label>
                <input type = "text" id="reponse" name="reponse" value = "<?php echo $reponselibelle ?>" required>
                <button class="btn btn-success" type="submit" >Enregistrer la réponse</button>
            </form>
            <form action="index.php?uc=quiz&action=supprimerReponse&idSondage=<?php echo $idSondage ?>&idReponse=<?php echo $idReponse ?>"
                  method="post" role="form">
                <button class="btn btn-success" type="submit" >Supprimer la réponse</button>
            </form>
        <?php }$numeroSondage++; ?>
        <form action="index.php?uc=quiz&action=creerReponse&idSondage=<?php echo $idSondage ?>&idQuestion=<?php echo $idQuestion ?>&numeroSondage=<?php echo $numeroSondage ?>"
              method="post" role="form">
            <input type="hidden" name = "txtSondage<?php echo $numeroSondage ?>" id="txtSondage<?php echo $numeroSondage ?>" value="0">
            <input type="button" id="bouton" value="Ajouter une réponse" onclick = 'creerReponse("Sondage", "<?php echo $numeroSondage; ?>");'>
            <input type="button" id="bouton" value="Supprimer une réponse" onclick = 'supprimerReponse("Sondage", "<?php echo $numeroSondage; ?>");'> 
            <div id="champsSondage<?php echo $numeroSondage ?>">
            </div>
            <button name = "btnSondage" class="btn btn-success" type="submit" >Enregistrer la ou les réponse(s)</button>
        </form>
    <?php
    }
}
?>
<div class="row">
    <div class="col-md-8">
        <h3>Créer question</h3>
        <form action="index.php?uc=quiz&action=creerQuestion&idSondage=<?php echo $idSondage ?>"
              method="post" role="form">
            <div class="form-group">
                <label for="question">Ma question: </label>
                <input type="text" id="question" name="question" required>
            </div>
            <div class="form-group">
                <label for="lstTypeQuestion">Type de question :</label>
                <select id="lstTypeQuestion"  name="lstTypeQuestion" class="form-control">
                    <option value="1">general</option>
                    <option value="2">sondage</option>
                </select>
                <label for="lstTypeReponse">Type de réponse :</label>
                <select id="lstTypeReponse"  name="lstTypeReponse" class="form-control">
                    <option value="1">une</option>
                    <option value="2">plusieurs</option>
                </select>   
                <input type="hidden" name = "txtCreation" id="txtCreation" value="0">
                <input type="button" id="bouton" value="Ajouter une réponse" onclick = "creerReponse('Creation', '')">
                <input type="button" id="bouton" value="Supprimer une réponse" onclick = "supprimerReponse('Creation', '')"> 
                <div id="champsCreation">
                </div>
            </div>
            <button name="btnCreation" class="btn btn-success" type="submit" >Ajouter </button>
        </form>
    </div>
</div>
<script>
    function creerReponse(nom, numero) {
        var element = document.getElementById("txt" + nom + numero);
        var score = element.value;
        ++score;
        document.getElementById("txt" + nom + numero).value = score;
        var nouveauInput = document.createElement('input');
        nouveauInput.type = 'text';
        nouveauInput.id = 'reponse' + score;
        nouveauInput.name = 'reponse' + score;
        nouveauInput.required = true;
        var champs = document.getElementById('champs' + nom + numero);
        champs.appendChild(nouveauInput);
    }

    function supprimerReponse(nom, numero) {
        var champs = document.getElementById('champs' + nom + numero);
        let total = champs.childElementCount;
        if (total > 0) {
            var nombre = document.getElementById("txt" + nom + numero);
            var score = nombre.value;
            --score;
            document.getElementById("txt" + nom + numero).value = score;
            champs.removeChild(champs.lastElementChild);
        }
    }
</script> 
