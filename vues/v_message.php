<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Message
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
        <?php
        echo $sondage['textedefin'];
        echo "<br>";
        echo "Cliquez ici pour revenir à l'accueil";
        ?>
        <div>
            <a href="index.php?uc=accueil"
               class="btn btn-primary" role="button">
                <br>Retour à l'accueil</a>
        </div>
    </div>
</div>