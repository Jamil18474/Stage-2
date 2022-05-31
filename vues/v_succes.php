<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Succès
 * 
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */

?>
<div class="alert alert-success" role="alert">
    <?php
    foreach ($_REQUEST['succes'] as $succes) {
        echo '<p>' . htmlspecialchars($succes) . '</p>';
    }
    ?>
</div>