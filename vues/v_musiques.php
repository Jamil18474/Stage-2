<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Liste Musiques : Gère l'affichage des musiques
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
<?php
if (isset($lesMusiques)) {
    foreach ($lesMusiques as $uneMusique) {
        $titre = $uneMusique['titre'];
        $audio = $uneMusique['audio'];
        $idMusique = $uneMusique['id'];
        ?>
        <video width="245" height="190" controls><source src="audio/<?php echo $audio; ?>"></video>
        <form action="index.php?uc=musiques&action=modifierTitre&idSondage=<?php echo $idSondage ?>&idMusique=<?php echo $idMusique ?>" 
              method="post" role="form">
            <label for="titre">Titre:</label>
            <input type = "text" id="titre" name="titre" value = "<?php echo $titre ?>" required> 
            <button class="btn btn-success" type="submit" >Enregistrer </button>
        </form>
        <form action="index.php?uc=musiques&action=modifierAudio&idSondage=<?php echo $idSondage ?>&idMusique=<?php echo $idMusique ?>" 
              method="post" role="form">
            <label for="audio">Audio:</label>
            <input type = "file" id="audio" name="audio" value = "<?php echo $audio ?>" accept="audio/*" required> 
            <button class="btn btn-success" type="submit" >Enregistrer </button>
        </form>
        <form action="index.php?uc=musiques&action=supprimerMusique&idSondage=<?php echo $idSondage ?>&idMusique=<?php echo $idMusique ?>" 
              method="post" role="form">
            <button class="btn btn-success" type="submit" >Supprimer </button>
        </form>
    <?php }
}
?>
<div class="row">
    <div class="col-md-8">
        <h3>Nouvelle Musique</h3>
        <form action="index.php?uc=musiques&action=creerMusique&idSondage=<?php echo $idSondage ?>" 
              method="post" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="titre">Ajouter une musique: </label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div class="form-group">
                <label for="audio">Pièce jointe:</label>             
                <input type="file" id="audio"  name="audio" accept="audio/*" required>
            </div> 
            <div class="form-group">
                <input type="submit"  name="submit">
            </div>
        </form>
    </div>
</div>
