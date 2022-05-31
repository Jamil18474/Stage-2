<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Menu
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

?>
<?php if ($estConnecte) {
    $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
?>
    <div class="header">
        <div class="row vertical-align">
            <div class="col-md-10">
                <ul class="nav nav-pills pull-right" role="tablist">
                    <li <?php if (!$uc || $uc == 'accueil') { ?>class="active"<?php } ?>>
                        <a href="index.php">
                            <span class="glyphicon glyphicon-home"></span>
                            Accueil
                        </a>
                    </li>
                    <?php 
                    if (estConnecte()){ ?>
                            <li <?php if ($uc == 'sondages') { ?>class="active"<?php } ?>>
                                <a href="index.php?uc=sondages">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    Gestion des sondages
                                </a>
                            </li>
                        <li <?php if ($uc == 'deconnexion') { ?>class="active"<?php } ?>>
                            <a href="index.php?uc=deconnexion&action=demandeDeconnexion">
                                <span class="glyphicon glyphicon-log-out"></span>
                                Déconnexion
                            </a>
                        </li>
                    <?php
                    } ?>                    
                </ul>              
            </div>
        </div>
    </div>
<?php
} 
