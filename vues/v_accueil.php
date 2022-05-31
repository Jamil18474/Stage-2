<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Accueil
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

?>
<div id="accueil">
    <h2>
        Gestion des sondages - Administrateur : <?php 
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']?>
    </h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Navigation
                </h3>
            </div>
            <div class="panel-body">
                    <a href="index.php?uc=sondages">
                    <span class="glyphicon glyphicon-pencil"></span>
                    Gestion des sondages
                    </a>
                <hr>
                <a href="index.php?uc=deconnexion&action=demandeDeconnexion">
                    <span class="glyphicon glyphicon-log-out"></span>
                    Déconnexion
                </a>
            </div>
        </div>
    </div>
</div>