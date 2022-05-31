<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Modification de Sondage
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

?>
<form action="index.php?uc=sondage&action=modifierSondage&idSondage=<?php echo $idSondage ?>" 
      method="post" role="form">
    <div>
        <a href="index.php?uc=sondages"
           class="btn btn-primary" role="button">
            <br>Retour à la liste des sondages</a>
    </div>
    <?php
    $societe = $sondage['societe'];
    $nom = $sondage['nom'];
    $dateDeDebut = $sondage['datededebut'];
    $heureDeDebut = $sondage['heurededebut'];
    $dateDeFin = $sondage['datedefin'];
    $heureDeFin = $sondage['heuredefin'];
    $texteDeFin = $sondage['textedefin'];
    ?>
    <div>
        <label for="societe">Societe:</label>
        <input type = "text" id="societe" name="societe" value = "<?php echo $societe ?>" required>
    </div>
    <div>
        <label for="nom">Nom du callout:</label>
        <input type = "text" id="nom" name="nom" value = "<?php echo $nom ?>" required>
    </div>
    <div>
        <label for="dateDeDebut">Date de début:</label>
        <input type = "date" id="dateDeDebut" name="dateDeDebut" value ="<?php echo $dateDeDebut ?>"required>
        <label for="heureDeDebut">Heure de début:</label>
        <input type = "time" id="heureDeDebut" name="heureDeDebut" value ="<?php echo $heureDeDebut ?>"required>
    </div>
    <div>
        <label for="dateDeFin">Date de fin:</label>
        <input type = "date" id="dateDeFin" name="dateDeFin" value ="<?php echo $dateDeFin ?>" required>
        <label for="heuredefin">Heure de fin:</label>
        <input type = "time" id="heureDeFin" name="heureDeFin" value ="<?php echo $heureDeFin ?>" required>
    </div>
    <div>
        <label for="texteDeFin">Texte de fin:</label>
        <textarea id="texteDeFin" name="texteDeFin" rows = "20" cols="100" required ><?php echo $texteDeFin ?></textarea>
    </div>
    <p></p>
    <div class="panel-body">
        <button class="btn btn-success" type="submit" >Modifier </button>
    </div>
</form>