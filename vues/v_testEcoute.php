<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * Vue Test des Musiques
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
        <audio id="player" preload="auto"  controls="">
        </audio>
        <div id="container">
            <ul>
                <li>
                    <input type = "button" id = "adorer" name="adorer" value = "J'adore">
                </li>
                <li>
                    <input type = "button" id = "aimer" name="aimer" value = "J'aime">
                </li>
                <li>
                    <input type = "button" id = "detester" name="detester" value = "Je n'aime pas">
                </li>
                <li>
                    <input type = "button" id = "inconnu" name="inconnu" value = "Je ne connais pas">
                </li>
                <li>
                    <input type = "button" id = "repetitif" name="repetitif" value = "Trop entendu">
                </li>
            </ul>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>

            testEcoute();

            function testEcoute() {
                const MAJ_SCORE_MUSIQUE = "index.php?uc=test&action=majScoreMusique";
                var idSondage = <?php echo json_encode($idSondage); ?>;
                var adresseIp = <?php echo json_encode($adresseIp); ?>;
                var lesAudios = <?php echo json_encode($lesAudios); ?>;
                var lesIdMusiques = <?php echo json_encode($lesIdMusiques); ?>;
                var i = 0;
                player = $("#player");
                adorer = $("#adorer");
                aimer = $("#aimer");
                detester = $("#detester");
                inconnu = $("#inconnu");
                repetitif = $("#repetitif");
                const MESSAGE = "index.php?uc=test&action=voirMessage&idSondage=" + idSondage + "&adresseIp=" + adresseIp;
                var type;
                var content = document.getElementById("container");
                content.style.display = "none";
                setTimeout(function () {
                    content.style.display = "block";
                }, 5000);
                var ul = document.querySelector('ul');
                player[0].src = "audio/" + lesAudios[i];
                player[0].play();
                adorer[0].addEventListener('click', function () {
                    content.style.display = "none";
                    setTimeout(function () {
                        content.style.display = "block";
                    }, 5000);
                    for (var p = ul.children.length; p >= 0; p--) {
                        ul.appendChild(ul.children[Math.random() * p | 0]);
                    }
                    type = 1;
                    adorer.load(MAJ_SCORE_MUSIQUE, {
                        type: type,
                        idMusique: lesIdMusiques[i]
                    });
                    i++;
                    if (i < lesAudios.length) {
                        player[0].src = "audio/" + lesAudios[i];
                        player[0].play();
                    } else {

                        document.location.href = MESSAGE;
                    }
                });
                aimer[0].addEventListener('click', function () {
                    content.style.display = "none";
                    setTimeout(function () {
                        content.style.display = "block";
                    }, 5000);
                    for (var p = ul.children.length; p >= 0; p--) {
                        ul.appendChild(ul.children[Math.random() * p | 0]);
                    }
                    type = 2;
                    aimer.load(MAJ_SCORE_MUSIQUE, {
                        type: type,
                        idMusique: lesIdMusiques[i]
                    });
                    i++;
                    if (i < lesAudios.length) {
                        player[0].src = "audio/" + lesAudios[i];
                        player[0].play();
                    } else {
                        document.location.href = MESSAGE;
                    }
                });
                detester[0].addEventListener('click', function () {
                    content.style.display = "none";
                    setTimeout(function () {
                        content.style.display = "block";
                    }, 5000);
                    for (var p = ul.children.length; p >= 0; p--) {
                        ul.appendChild(ul.children[Math.random() * p | 0]);
                    }
                    type = 3;
                    detester.load(MAJ_SCORE_MUSIQUE, {
                        type: type,
                        idMusique: lesIdMusiques[i]
                    });
                    i++;
                    if (i < lesAudios.length) {
                        player[0].src = "audio/" + lesAudios[i];
                        player[0].play();
                    } else {

                        document.location.href = MESSAGE;
                    }
                });
                inconnu[0].addEventListener('click', function () {
                    content.style.display = "none";
                    setTimeout(function () {
                        content.style.display = "block";
                    }, 5000);
                    for (var p = ul.children.length; p >= 0; p--) {
                        ul.appendChild(ul.children[Math.random() * p | 0]);
                    }
                    type = 4;
                    inconnu.load(MAJ_SCORE_MUSIQUE, {
                        type: type,
                        idMusique: lesIdMusiques[i]
                    });
                    i++;
                    if (i < lesAudios.length) {
                        player[0].src = "audio/" + lesAudios[i];
                        player[0].play();
                    } else {
                        document.location.href = MESSAGE;
                    }
                });
                repetitif[0].addEventListener('click', function () {
                    content.style.display = "none";
                    setTimeout(function () {
                        content.style.display = "block";
                    }, 5000);
                    for (var p = ul.children.length; p >= 0; p--) {
                        ul.appendChild(ul.children[Math.random() * p | 0]);
                    }
                    type = 5;
                    repetitif.load(MAJ_SCORE_MUSIQUE, {
                        type: type,
                        idMusique: lesIdMusiques[i]
                    });
                    i++;
                    if (i < lesAudios.length) {
                        player[0].src = "audio/" + lesAudios[i];
                        player[0].play();
                    } else {
                        document.location.href = MESSAGE;
                    }
                });
            }
        </script>
    </div>
</div>