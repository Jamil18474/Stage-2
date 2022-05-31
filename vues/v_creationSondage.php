<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Création de Sondage
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

?>
<form action="index.php?uc=sondage&action=creerSondage" 
      method="post" role="form">
    <div>
        <a href="index.php?uc=sondages"
           class="btn btn-primary" role="button">
            <br>Retour à la liste des sondages</a>
    </div>
    <div>
        <label for="societe">Societe:</label>
        <input type = "text" id="societe" name="societe" required>
    </div>
    <div>
        <label for="nom">Nom du callout:</label>
        <input type = "text" id="nom" name="nom" required>
    </div>
    <div>
        <label for="dateDeDebut">Date de debut:</label>
        <input type = "date" id="dateDeDebut" name="dateDeDebut" required>
        <label for="heureDeDebut">Heure de debut:</label>
        <input type = "time" id="heureDeDebut" name="heureDeDebut" required>
    </div>
    <div>
        <label for="dateDeFin">Date de fin:</label>
        <input type = "date" id="dateDeFin" name="dateDeFin" required>
        <label for="heureDeFin">Heure de fin:</label>
        <input type = "time" id="heureDeFin" name="heureDeFin" required>
    </div>
    <div>
        <label for="texteDeFin">Texte de fin:</label>
        <textarea id="texteDeFin" name="texteDeFin" rows = "20" cols="100" ></textarea>
    </div>
    <p></p>
    <div class="panel-body">
        <button class="btn btn-success" type="submit" >Ajouter </button>
    </div>
</form>