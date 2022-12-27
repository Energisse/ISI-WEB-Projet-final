<?php abstract class Modele { 
    private static $bdd = null;
    // Effectue la connexion à la BDD// Instancie et renvoie l'objet PDO associé 
    protected static function executerRequete($sql, $params= null) {
        if($params == null) { 
            $resultat= Modele::getBdd()->query($sql); // exécution directe 
        } 
        else{
            $resultat= Modele::getBdd()->prepare($sql); // requête préparée 
            $resultat->execute($params);
        }   
        return $resultat; 
    } 
    private static function getBdd() { 
        if(Modele::$bdd != null)return Modele::$bdd;
        Modele::$bdd = new PDO('mysql:host=localhost;dbname=web4shop;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
        return Modele::$bdd; 
    }

    protected static function lastInsertId(){
        return Modele::getBdd()->lastInsertId();
    }
}