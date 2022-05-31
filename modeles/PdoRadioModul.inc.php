<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Classe d'accès aux données.
 * 
 * Utilise les services de la classe PDO
 * pour l'application RadioModul
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoRadioModul qui contiendra l'unique instance de la classe
 *
 * PHP Version 7
 * 
 * @category Stage
 * @package Radio MODUL
 * @author Jamil
 */
class PdoRadioModul {
    private static $serveur = 'mysql:host=';
    private static $bdd = 'dbname=';
    private static $user = '';
    private static $mdp = '';
    private static $monPdo;
    private static $monPdoRadioModul = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() 
    {
        $lines = getLines();
        $servername = $lines[0];
        $username = $lines[1];
        $password = $lines[2];
        $database = $lines[3];
        PdoRadioModul::$monPdo = new PDO(
                PdoRadioModul::$serveur . $servername . ';' . PdoRadioModul::$bdd . $database,
                PdoRadioModul::$user . $username,
                PdoRadioModul::$mdp . $password
        );
        PdoRadioModul::$monPdo->query('SET CHARACTER SET utf8');
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct() 
    {
        PdoRadioModul::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoRadioModul = PdoRadioModul::getPdoRadioModul();
     *
     * @return l'unique objet de la classe PdoRadioModul
     */
    public static function getPdoRadioModul() 
    {
        if (PdoRadioModul::$monPdoRadioModul == null) {
            PdoRadioModul::$monPdoRadioModul = new PdoRadioModul();
        }
        return PdoRadioModul::$monPdoRadioModul;
    }

    /**
     * Retourne les informations de l'administrateur
     *
     * @param String $login Login de l'administrateur
     * @param String $mdp   Mot de passe de l'administrateur
     *
     * @return ArrayObject L'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosAdmin($login, $mdp) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT admin.id AS id, admin.nom AS nom, admin.prenom AS prenom FROM admin WHERE login = :login AND mdp = SHA2(:mdp, 512)'
        );
        $requetePrepare->bindParam(':login', $login, PDO::PARAM_STR);
        $requetePrepare->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle musique pour un sondage donné à partir des informations fournies en paramètre
     * 
     * @param String $titre Titre de la musique
     * @param String $audio Audio
     * @param String $idsondage ID du sondage
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function creeNouvelleMusique($titre, $audio, $idsondage)
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'INSERT INTO musique (titre, audio, scoreadorer, scoreaimer, scoredetester, scoreinconnu, scorerepetitif, idsondage) VALUES (:unTitre, :unAudio, 0, 0, 0, 0, 0, :idsondage) '
        );
        $requetePrepare->bindParam(':unTitre', $titre, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unAudio', $audio, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        if($requetePrepare->execute()){
            $return = true;
        }               
        else{
            $return = false;
        }
        return $return;
    }

    /**
     * Crée une nouvelle question pour un sondage donné à partir des informations fournies en paramètre
     * 
     * @param String $libelle Libelle de la question
     * @param String $idtypequestion ID du type de la question
     * @param String $idtypereponse ID du type de la réponse
     * param String $idsondage ID du sondage
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function creeNouvelleQuestion($libelle, $idtypequestion, $idtypereponse, $idsondage)
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'INSERT INTO question (libelle, idtypequestion, idtypereponse, idsondage) VALUES (:unLibelle, :idtypequestion, :idtypereponse, :idsondage) '
        );
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idtypequestion', $idtypequestion, PDO::PARAM_INT);
        $requetePrepare->bindParam(':idtypereponse', $idtypereponse, PDO::PARAM_INT);
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        if($requetePrepare->execute()){
            $return = true;
        }               
        else{
            $return = false;
        }
        return $return;
    }

    /**
     * Crée un nouveau sondage à partir des informations fournies en paramètre
     * 
     * @param String $societe Société du sondage
     * @param String $nom Nom du sondage
     * @param String $datededebut Date de début du sondage
     * @param String $heurededebut Heure de début du sondage
     * @param String $datedefin Date de fin du sondage
     * @param String $heuredefin Heure de fin du sondage
     * @param String $textedefin Texte de fin du sondage
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function creeNouveauSondage($societe, $nom, $datededebut, $heurededebut, $datedefin, $heuredefin, $textedefin) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'INSERT INTO sondage (societe, nom, datededebut, heurededebut, datedefin, heuredefin, textedefin) VALUES (:uneSociete,:unNom, :uneDateDeDebut, :uneHeureDeDebut, :uneDateDeFin, :uneHeureDeFin, :unTexteDeFin) '
        );
        $requetePrepare->bindParam(':uneSociete', $societe, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unNom', $nom, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDateDeDebut', $datededebut, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneHeureDeDebut', $heurededebut, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDateDeFin', $datedefin, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneHeureDeFin', $heuredefin, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unTexteDeFin', $textedefin, PDO::PARAM_STR);
        if($requetePrepare->execute()) {
            $return = true;
        }               
        else{
            $return = false;
        }
        return $return;
    }

    /**
     * Crée une nouvelle réponse pour une question donnée à partir des informations fournies en paramètre
     * 
     * @param String $libelle Libellé de la réponse
     * @param String $idquestion ID de la question
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function creeNouvelleReponse($libelle, $idquestion) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'INSERT INTO reponse (libelle, score, idquestion) VALUES (:unLibelle, 0, :idquestion)'
        );

        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idquestion', $idquestion, PDO::PARAM_STR);
        if($requetePrepare->execute()){
            $return = true;
        }               
        else{
            $return = false;
        }
        return $return;
    }

    /**
     * Crée une nouvelle addresse IP pour un sondage donné à partir des informations fournies en paramètre
     * 
     * @param String $adresseip Adresse IP
     * @param String $idsondage ID du sondage
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function creeNouvelleAdresseIp($adresseip, $idsondage)
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'INSERT INTO utilisateur (adresseip, idsondage) VALUES (:uneAdresseIp,:idsondage) '
        );

        $requetePrepare->bindParam(':uneAdresseIp', $adresseip, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        if($requetePrepare->execute()){
            $return = true;
        }               
        else{
            $return = false;
        }
        return $return;
    }

    /**
     * Retourne l'id, le libellé et le type de réponse de la question pour un type de question et un sondage donnés 
     * 
     * @param Integer $idtypequestion ID du type de la question
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject L'id et le libellé des questions, le libellé du type de la réponse
     */
    public function getLesQuestionsType($idtypequestion, $idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare('
                SELECT question.id as id, question.libelle as questionlibelle, question.idtypereponse as idtypereponse
                FROM question 
                WHERE question.idtypequestion = :idtypequestion AND idsondage = :idsondage ORDER BY question.id'
        );
        $requetePrepare->bindParam(':idtypequestion', $idtypequestion, PDO::PARAM_INT);
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }


    
    /**
     * Retourne les informations de toutes les questions pour un sondage donné
     * 
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif des questions
     */
    public function getLesQuestions($idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT * FROM question WHERE question.idsondage = :idsondage ORDER BY question.id'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne tous les id des questions cochees pour un sondage donné
     * 
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif des id des questions cochees
     */
    public function getLesIdQuestionsCochees($idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT question.id as id FROM question WHERE question.idsondage = :idsondage AND question.choix = "plusieurs" ORDER BY question.id'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne tous les audios d'un sondage donné
     * 
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif des audios
     */
    public function getLesAudios($idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT musique.audio as audio FROM musique WHERE musique.idsondage = :idsondage ORDER BY musique.id'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesAudios = array();
        while ($laLigne = $requetePrepare->fetch(PDO::FETCH_ASSOC)) {
            $lesAudios[] = $laLigne['audio']; 
        }
        return $lesAudios;
    }

    /**
     * Retourne tous les id des musiques d'un sondage donné
     * 
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif des id des musiques
     */
    public function getLesIdMusiques($idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT musique.id as id FROM musique WHERE musique.idsondage = :idsondage ORDER BY musique.id'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIdMusiques = array();
        while ($laLigne = $requetePrepare->fetch(PDO::FETCH_ASSOC)) {
            $lesIdMusiques[] = $laLigne['id']; 
        }
        return $lesIdMusiques;
    }
    
    
    /**
     * Retourne toutes les informations d'un sondage 
     * 
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif du sondage
     */
    public function getSondage($idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT * FROM sondage WHERE sondage.id = :idsondage'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retourne les sondages à partir d'une recherche
     * 
     * @param String $valeur Valeur de la recherche
     * @param Boolean $archive La valeur que prendra le champ "archive"
     * 
     * @return ArrayObject un tableau associatif des sondages
     */
    public function getLesSondagesRecherche($valeur, $archive) 
    {
        if ($valeur == "") {
            $requetePrepare = PdoRadioModul::$monPdo->prepare(
                    'SELECT * FROM sondage WHERE archive = :archive ORDER BY sondage.id'
            );
        } else {
            $requetePrepare = PdoRadioModul::$monPdo->prepare(
                    "SELECT * FROM sondage WHERE nom LIKE '%$valeur%' AND archive = :archive ORDER BY sondage.id"
            );
        }
        $requetePrepare->bindParam(':archive', $archive, PDO::PARAM_BOOL);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne les informations de toutes les musiques d'un sondage donné
     * 
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif des musiques
     */
    public function getLesMusiques($idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT * FROM musique WHERE idsondage = :idsondage ORDER BY musique.id'
        );

        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne toutes les adresses IP des utilisateurs pour un sondage donné
     * 
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif des adresses IP
     */
    public function getLesIp($idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT utilisateur.adresseip as adresseip FROM utilisateur WHERE idsondage = :idsondage ORDER BY utilisateur.id'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIp = array();
        while ($laLigne = $requetePrepare->fetch(PDO::FETCH_ASSOC)) {
            $lesIp[] = $laLigne['adresseip']; 
        }
        return $lesIp;
    }

    /**
     * Retourne toutes les adresses IP des utilisateurs ayant fini le sondage donné en paramètre
     * 
     * @param Boolean $fini La valeur que prendra le champ "fini"
     * @param String $idsondage ID du sondage
     * 
     * @return ArrayObject un tableau associatif des adresses IP
     */
    public function getLesIpFini($fini, $idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT adresseip as adresseip FROM utilisateur WHERE idsondage = :idsondage AND fini = :fini ORDER BY utilisateur.id'
        );
        $requetePrepare->bindParam(':fini', $fini, PDO::PARAM_BOOL );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIpFini = array();
        while ($laLigne = $requetePrepare->fetch(PDO::FETCH_ASSOC)) {
            $lesIpFini[] = $laLigne['adresseip']; 
        }
        return $lesIpFini;
    }

    /**
     * Retourne toutes les informations des réponses pour une question donnée
     * 
     * @param String $idquestion ID de la question
     * 
     * @return ArrayObject un tableau associatif des adresses IP
     */
    public function getLesReponses($idquestion) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT reponse.id as id, reponse.libelle as reponselibelle, reponse.score as score, reponse.idquestion as idquestion FROM reponse WHERE idquestion = :idquestion ORDER BY reponse.id'
        );
        $requetePrepare->bindParam(':idquestion', $idquestion, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne tous les id des réponses pour une question donnée
     * 
     * @param String $idquestion ID de la question
     * 
     * @return ArrayObject un tableau associatif des id des réponses
     */
    public function getLesIdReponses($idquestion) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT id as id FROM reponse WHERE idquestion = :idquestion ORDER BY reponse.id'
        );
        $requetePrepare->bindParam(':idquestion', $idquestion, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIdReponses = array();
        while ($laLigne = $requetePrepare->fetch(PDO::FETCH_ASSOC)) {
            $lesIdReponses[] = $laLigne['id']; 
        }
        return $lesIdReponses;
    }
    
    /**
     * Retourne le score total des reponses pour une question donnée.
     * 
     * @param String $idquestion ID de la question
     * 
     * @return Integer Le score total
     */
    public function getTotalScoreReponses($idquestion)
    {
        $sql = "SELECT SUM(score) as sumScore FROM reponse WHERE idquestion = :idquestion";
        $requetePrepare = PdoRadioModul::$monPdo->prepare($sql);
        $requetePrepare->bindParam(':idquestion', $idquestion, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch(PDO::FETCH_ASSOC);
        return $laLigne['sumScore'];
    }

    /**
     * Retourne les informations des sondages soit non archivés soit archivés selon le paramètre
     * 
     * @param Boolean $archive La valeur que prendra le champ "archive"
     * 
     * @return ArrayObject un tableau associatif des sondages
     */
    public function getLesSondages($archive) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'SELECT * FROM sondage WHERE archive = :archive ORDER BY sondage.id'
        );
        $requetePrepare->bindParam(':archive', $archive, PDO::PARAM_BOOL);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

    

    /**
     * Retourne le dernier id des quiz.
     * 
     * @return String Le dernier id
     */
    public function derniereQuestion() 
    {
        $sql = "SELECT MAX(id) as dernierId FROM question";
        $requetePrepare = PdoRadioModul::$monPdo->prepare($sql);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch(PDO::FETCH_ASSOC);
        $dernierId = $laLigne['dernierId'];
        return $dernierId;
    }

    /**
     * Modifie le sondage
     * 
     * @param String $idsondage ID du sondage
     * @param String $societe Société du sondage
     * @param String $nom Nom du sondage
     * @param String $datededebut Date de début du sondage
     * @param String $heurededebut Heure de début du sondage
     * @param String $datedefin Date de fin du sondage
     * @param String $heuredefin Heure de fin du sondage
     * @param String $textedefin Texte de fin du sondage
     *  
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function modifierSondage($idsondage, $societe, $nom, $datededebut, $heurededebut, $datedefin, $heuredefin, $textedefin)
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE sondage '
                . 'SET societe = :uneSociete, nom = :unNom, datededebut = :uneDatededebut, heurededebut = :uneHeurededebut, datedefin = :uneDatedefin, heuredefin = :uneHeuredefin, textedefin = :unTextedefin where id = :idsondage'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneSociete', $societe, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unNom', $nom, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDatededebut', $datededebut, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneHeurededebut', $heurededebut, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDatedefin', $datedefin, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneHeuredefin', $heuredefin, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unTextedefin', $textedefin, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Modifie la question
     * 
     * @param String $idquestion ID de la question
     * @param String $libelle Libelle de la question
     * @param String $idtypequestion ID du type de la question
     * @param String $idtypereponse ID du type de la réponse
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function modifierQuestion($idquestion, $libelle, $idtypequestion, $idtypereponse) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE question SET libelle = :unLibelle, idtypequestion = :idtypequestion, idtypereponse = :idtypereponse WHERE question.id = :idquestion'
        );
        $requetePrepare->bindParam(':idquestion', $idquestion, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idtypequestion', $idtypequestion, PDO::PARAM_STR);
        $requetePrepare->bindParam(':idtypereponse', $idtypereponse, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Modifie la réponse
     * 
     * @param String $idreponse ID de la réponse
     * @param String $libelle Libelle de la réponse
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function modifierReponse($idreponse, $libelle) {

        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE reponse SET libelle = :unLibelle WHERE reponse.id = :idreponse'
        );
        $requetePrepare->bindParam(':idreponse', $idreponse, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Met le champ fini de la table ip à true.
     * 
     * @param String $adresseip Addresse IP
     * @param Boolean $fini La valeur que prendra le champ "fini"
     * @param String $idsondage ID du sondage
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function majFiniIp($adresseip, $fini, $idsondage) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE utilisateur SET fini = :fini WHERE utilisateur.adresseip = :uneAdresseIp AND utilisateur.idsondage = :idsondage'
        );
        $requetePrepare->bindParam(':uneAdresseIp', $adresseip, PDO::PARAM_STR);
        $requetePrepare->bindParam(':fini', $fini, PDO::PARAM_BOOL);
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Modifie le titre d'une musique
     * 
     * @param String $idmusique ID de la musique
     * @param String $titre Titre de la musique
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function modifierTitre($idmusique, $titre)
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE musique SET titre = :unTitre WHERE musique.id = :idmusique'
        );
        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unTitre', $titre, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Modifie l'audio
     * 
     * @param String $idmusique ID de la musique
     * @param String $audio Audio
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function modifierAudio($idmusique, $audio)
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE musique SET audio = :unAudio WHERE musique.id = :idmusique'
        );
        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unAudio', $audio, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }
    
    /**
     * Met le champ actif à true.
     * 
     * @param String $idsondage ID du sondage
     * @param Boolean $actif La valeur que prendra le champ "actif"
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function activerSondage($idsondage, $actif) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE sondage SET actif = :actif WHERE sondage.id = :idsondage'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->bindParam(':actif', $actif, PDO::PARAM_BOOL);
        return $requetePrepare->execute();
    }

    /**
     * Met le champ archive à true.
     * 
     * @param String $idsondage ID du sondage
     * @param Boolean $archive La valeur que prendra le champ "archive"
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function archiverSondage($idsondage, $archive) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE sondage SET archive = :archive WHERE sondage.id = :idsondage'
        );
        $requetePrepare->bindParam(':idsondage', $idsondage, PDO::PARAM_STR);
        $requetePrepare->bindParam(':archive', $archive, PDO::PARAM_BOOL);
        return $requetePrepare->execute();
    }

    /**
     * Augmente le score d'une réponse de 1
     * 
     * @param String $idreponse ID de la réponse
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function majScoreReponse($idreponse) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE reponse SET score = score + 1 WHERE reponse.id = :idreponse'
        );
        $requetePrepare->bindParam(':idreponse', $idreponse, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Augmente le score de l'appréciation "adorer" de 1
     * 
     * @param String $idmusique ID de la musique
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function majScoreAdorer($idmusique) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE musique SET scoreadorer = scoreadorer + 1 WHERE musique.id = :idmusique'
        );

        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Augmente le score de l'appréciation "aimer" de 1
     * 
     * @param String $idmusique ID de la musique
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function majScoreAimer($idmusique) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE musique SET scoreaimer = scoreaimer + 1 WHERE musique.id = :idmusique'
        );
        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Augmente le score de l'appréciation "detester" de 1
     * 
     * @param String $idmusique ID de la musique
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function majScoreDetester($idmusique) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE musique SET scoredetester = scoredetester + 1 WHERE musique.id = :idmusique'
        );
        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Augmente le score de l'appréciation "inconnu" de 1
     * 
     * @param String $idmusique ID de la musique
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function majScoreInconnu($idmusique) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE musique SET scoreinconnu = scoreinconnu + 1 WHERE musique.id = :idmusique'
        );
        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Augmente le score de l'appréciation "repetitif" de 1
     * 
     * @param String $idmusique ID de la musique
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function majScoreRepetitif($idmusique) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'UPDATE musique SET scorerepetitif = scorerepetitif + 1 WHERE musique.id = :idmusique'
        );
        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Supprime les réponses dont l'id de la question est passé en argument
     * 
     * @param String $idquestion ID de la question
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function supprimerReponses($idquestion) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'DELETE FROM reponse WHERE reponse.idquestion = :idquestion'
        );
        $requetePrepare->bindParam(':idquestion', $idquestion, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Supprime la réponse dont l'id est passé en argument
     * 
     * @param String $idreponse ID de la réponse
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function supprimerReponse($idreponse) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'DELETE FROM reponse WHERE reponse.id = :idreponse'
        );
        $requetePrepare->bindParam(':idreponse', $idreponse, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Supprime la question dont l'id est passé en argument
     * 
     * @param String $idquestion ID de la question
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function supprimerQuestion($idquestion) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'DELETE FROM question WHERE question.id = :idquestion'
        );
        $requetePrepare->bindParam(':idquestion', $idquestion, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }

    /**
     * Supprime la musique dont l'id est passé en argument
     * 
     * @param String $idmusique ID de la musique
     * 
     * @return Boolean Vrai si la requête est un succès, faux sinon
     */
    public function supprimerMusique($idmusique) 
    {
        $requetePrepare = PdoRadioModul::$monPdo->prepare(
                'DELETE FROM musique WHERE musique.id = :idmusique'
        );
        $requetePrepare->bindParam(':idmusique', $idmusique, PDO::PARAM_STR);
        return $requetePrepare->execute();
    }
}
