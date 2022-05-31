<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Liste Sondages : Gère l'affichage des sondages
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */
?>
<form action="index.php?uc=sondages&action=rechercherSondages&archive=<?php echo $archive ?>" 
      method="post" role="form">
    <span>
        <label for="txtRecherche">Recherche </label>
        <input type="text" id="txtRecherche" style= "width: 200px; height: 30px" name="txtRecherche" 
               class="form-control" id="text">
        <button class="btn btn-success" type="submit">Recherche</button>
        <button class="btn btn-danger" type="reset">Effacer la recherche</button>
    </span>
</form>
<div class="panel-body">
    <div class="col-xs-offset-5">
        <form action="index.php?uc=sondages&action=voirArchives" 
              method="post" role="form">
            <input type = "submit" id = "submit" name="submit" value = "archives">
        </form>
        <form action="index.php?uc=sondages" 
              method="post" role="form">
            <input type = "submit" id = "submit" name="submit" value = "sondages">
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Liste des sondages</div>
        <div class="col-xs-4 col-md-6">
            <table class="table table-bordered table-responsive">
<?php
if (is_array($lesSondages)) {
    foreach ($lesSondages as $unSondage) {
        $idSondage = $unSondage['id'];
        $societe = $unSondage['societe'];
        $nom = $unSondage['nom'];
        $dateDeDebut = $unSondage['datededebut'];
        $heureDeDebut = $unSondage['heurededebut'];
        $dateDeFin = $unSondage['datedefin'];
        $heureDeFin = $unSondage['heuredefin'];
        $actif = $unSondage['actif'];
        $archive = $unSondage['archive'];
        $lesMusiques = $pdo->getLesMusiques($idSondage);
        $lesQuestions = $pdo->getLesQuestions($idSondage);
        $dateOK = valideDate($dateDeFin, $heureDeFin);
        ?>     
                        <thead>
                            <tr>
                                <th>Societe</th>
                                <th>Nom</th>  
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Résultats</th>
        <?php if ($archive == false) { ?>
                                    <th>Lien</th>
                                    <th>Gérer les musiques</th>  
                                    <th>Gérer les quiz</th>  
                                    <th>Accessible</th>  
        <?php } ?>
                            </tr>
                        </thead>  
                        <tbody>
                            <tr>
                                <td> <?php echo $societe ?></td>
                                <td> <?php echo $nom ?></td>
                                <td> <?php echo $dateDeDebut . " à " . $heureDeDebut ?></td>
                                <td> <?php echo $dateDeFin . " à " . $heureDeFin ?></td>
                                <td>   
                                    <a href="index.php?uc=stats&action=statsMusiques&idSondage=<?php echo $idSondage ?>"
                                       class="btn btn-default" role="button">
                                        <br>Stats</a>
                                </td> 
                                <td>
        <?php if ($archive == false) {
            if ($actif == true && $dateOK == true) {
                ?>
                                            <a href="index.php?uc=test&action=test&idSondage=<?php echo $idSondage ?>" >Test</a>

                                        <?php } else { ?>
                                            Test
                                        <?php } ?>
                                    </td>
                                    <td>   
                                        <a href="index.php?uc=musiques&action=voirMusiques&idSondage=<?php echo $idSondage ?>"
                                           class="btn btn-default" role="button" >
                                            <br>Gérer</a>

                                    </td> 
                                    <td>   
                                        <a href="index.php?uc=quiz&action=voirQuiz&idSondage=<?php echo $idSondage ?>"
                                           class="btn btn-default" role="button">
                                            <br>Gérer</a>
                                    </td> 
                                    <td> 
                                        <?php if ($actif == true) {
                                            ?>
                                            <input type="checkbox" id="actif" name="actif" checked disabled>
                                            <label for="actif"></label>
                                        <?php } else { ?>
                                            <input type="checkbox" id="actif" name="actif" disabled>
                                            <label for="actif"></label>
                                        <?php } ?>
                                    </td>
                                    <td>  
                                        <?php if ($actif == false && !empty($lesMusiques) && !empty($lesQuestions)) { ?>
                                            <a href="index.php?uc=sondages&action=activerSondage&idSondage=<?php echo $idSondage ?>"
                                               class="btn btn-default" role="button">
                                                <br>Activer</a>
                                        <?php } ?>
                                    </td> 
                                    <td>  
                                        <a href="index.php?uc=sondage&action=voirModificationSondage&idSondage=<?php echo $idSondage ?>"
                                           class="btn btn-default" role="button">
                                            <br>Modifier</a>
                                    </td> 
                                    <td>  
                                        <a href="index.php?uc=sondages&action=archiverSondage&idSondage=<?php echo $idSondage ?>"
                                           class="btn btn-default" role="button">
                                            <br>Archiver</a>
                                    </td> 
                                <?php } ?>
                            </tr>     
                        <?php }
                    }
                    ?>
                </tbody>  
            </table>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-xs-offset-10">
            <a href="index.php?uc=sondage&action=voirCreationSondage"
               class="btn btn-primary" role="button">
                <br>Ajouter un nouveau sondage</a>
        </div>
    </div>
</div>