<?php
include_once("settings.inc.php");

class Database {

    private $db; // PDO objekt databaze

    public function __construct(){
        global $db_server, $db_name, $db_user, $db_pass;        
        // informace se berou ze settings
        $this->db = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->query("SET NAMES utf8");
        session_start();
    }

    /*public function __construct($host, $dbname, $usr, $pas){
        $this->db = new PDO("mysql:host=$host;dbname=$dbname", $usr, $pas);
        session_start();
    }*/

    /**
     *  Provede dotaz a buď vrátí jeho výsledek, nebo null a vypíše chybu.
     *  @param string $dotaz    Dotaz.
     *  @return object          Vysledek dotazu.
     */
    private function executeQuery($dotaz){
        $res = $this->db->query($dotaz);
        if (!$res) {
            $error = $this->db->errorInfo();
            echo $error[2];
            return null;
        } else {
            return $res;            
        }
    }

    /**
     *  Prevede vysledny objekt dotazu na pole.
     *  @param object $obj  Objekt s vysledky dotazu.
     *  @return array       Pole s vysledky dotazu.
     */
    private function resultObjectToArray($obj){
        // získat po řádcích            
        /*while($row = $vystup->fetch(PDO::FETCH_ASSOC)){
            $pole[] = $row['login'].'<br>';
        }*/
        return $obj->fetchAll(); // všechny řádky do pole        
    }

    /**
     *  Vraci prava uzivatelu.
     *  @return array   Dostupna prava uzivatelu.
     */
    public function allRights(){
        $q = "SELECT * FROM prava;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        return array_reverse($res); // pole otocim
    }
    
    /**
     *  Vraci pravo Autor.
     *  @return array   Pravo Autor.
     */
    public function rightAutor(){
        $q = "SELECT * FROM prava
                WHERE prava.idprava=3;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        return $res;
    }

    /**
     *  Vraci vsechny informace o uzivateli.
     *  @param string $login    Login uzivatele.
     *  @return array           Pole s informacemi o konkretnim uzivateli nebo null.
     */
    public function allUserInfo($login){
        $stmt = $this->db->prepare("SELECT * FROM uzivatele, prava
                WHERE uzivatele.login = :login
                  AND prava.idprava = uzivatele.idprava;");
        
        $lo = $login;
        
        $stmt->bindParam(':login', $lo);
        
        $stmt->execute();
        
        
        $stmt = $this->resultObjectToArray($stmt);
        //print_r($res);
        if($stmt != null && count($stmt)>0){
            // vracim pouze prvni radek, ve kterem je uzivatel
            return $stmt[0];
        } else {
            return null;
        }
    }

    /**
     *  Vraci vsechny informace o vsech uzivatelich.
     *  @return array           Pole s informacemi o vsech uzivatelich nebo null.
     */
    public function allUsersInfo(){
        $q = "SELECT * FROM uzivatele, prava
                WHERE prava.idprava = uzivatele.idprava;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        //print_r($res);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     *  Vraci vsechny uzivatele.
     *  @return array           Pole s informacemi o vsech uzivatelich nebo null.
     */
    public function allUsers(){
        $q = "SELECT * FROM uzivatele";
        $res = $this->executeQuery($q);
        $res =$this->resultObjectToArray($res);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     * Vraci vsechny prispevky vsech autoru.
     * @return array        Pole se vsemi prispevky vsech uzivatelu nebo null.
     */
    public function vsechnyPrispevky(){
        $q = "SELECT * FROM prispevek";
        $res = $this->executeQuery($q);
        $res =$this->resultObjectToArray($res);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     *  Smaze dany prispevek z databaze.
     *  @param integer $prispevekID  ID prispevku
     *  @return boolean         Podarilo se?
     */
    public function smazatPrispevek($prispevekID){
        $stmt = $this->db->prepare("DELETE FROM prispevek
                WHERE id_prispevek=:prispevekID");
        
        $pID = $prispevekID;
        
        $stmt->bindParam(':prispevekID', $pID);
        
        $stmt->execute();
        
        return true;
    }
    
    /**
     *  Upravi dany prispevek.
     *  @param string $nazev  nazev prispevku
     *  @param string $abstract  abstract prispevku
     *  @param string $pdfSoubor  pdf soubor prispevku
     *  @param integer $prispevekID  ID prispevku
     *  @return boolean         Podarilo se?
     */
    public function upravitPrispevek($nazev, $abstract, $pdfSoubor, $prispevekID) {
        $stmt = $this->db->prepare("UPDATE prispevek
                                SET nazev = :nazev, abstract = :abstract, pdf_soubor = :pdfSoubor
                                WHERE id_prispevek = $prispevekID");
        $na = $nazev;
        $ab = $abstract;
        $pd = $pdfSoubor;
        
        $stmt->bindParam(':nazev', $na);
        $stmt->bindParam(':abstract', $ab);
        $stmt->bindParam(':pdfSoubor', $pd);
        
        $stmt->execute();
        
        return true;
    }
    
    /**
     *  Vrati dany prispevek.
     *  @param integer $prispevekID  ID prispevku
     *  @return array         Pole s danym prispevkem.
     */
    public function jedenPrispevek($prispevekID) {
        $q = "SELECT * FROM prispevek
                WHERE id_prispevek=$prispevekID";
        $res = $this->executeQuery($q);
        if($res != null && count($res)>0){
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     *  Vrati prumer hodnoceni prispevku ze vsech posudku.
     *  @param integer $prispevekID  ID prispevku
     *  @return double         Prumer nebo null.
     */
    public function hodnoceniPrispevku($prispevekID) {
        $q = "SELECT * FROM posudek
                WHERE posudek.id_prispevek=$prispevekID;";
        $res = $this->executeQuery($q);
        if($res != null && count($res)>0){
            $average = 0;
            $count = 0;
            foreach($res as $r) {
                if($r['originalita'] != 0 && $r['tema'] != 0 && $r['technicka_kvalita'] != 0 && $r['jazykova_kvalita'] != 0 && $r['doporuceni'] != 0) {
                    $average += $r['originalita'];
                    $average += $r['tema'];
                    $average += $r['technicka_kvalita'];
                    $average += $r['jazykova_kvalita'];
                    $average += $r['doporuceni'];
                    $count += 5;
                }
            }
            if($count > 0) {
                $result = $average / $count;
                return $result;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
    /**
     *  Vrati posudky nalezici danemu prispevku.
     *  @param integer $prispevekID  ID prispevku
     *  @return array         Pole s posudky nalezici danemu prispevku.
     */
    public function posudkyPrispevku($prispevekID) {
        $q = "SELECT * FROM posudek
                WHERE posudek.id_prispevek=$prispevekID";
        $res = $this->executeQuery($q);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     *  Vytvori v databazi novy prispevek.
     *
     *  @return boolean         Podarilo se prispevek vytvorit?
     */
    public function pridatPrispevek($nazev, $autor, $abstract, $pdfSoubor) {
        $stmt = $this->db->prepare("INSERT INTO prispevek(nazev,autor,abstract,pdf_soubor,rozhodnuti,post)
            VALUES (:nazev,:autor,:abstract,:pdfSoubor,'ne','ne')");
        
        $na = $nazev;
        $au = $autor;
        $ab = $abstract;
        $pd = $pdfSoubor;
        
        $stmt->bindParam(':nazev', $na);
        $stmt->bindParam(':autor', $au);
        $stmt->bindParam(':abstract', $ab);
        $stmt->bindParam(':pdfSoubor', $pd);
        
        $stmt->execute();
        
        return true;
    }
    
    /**
     *  Nastavi rozhodnuti prispevku na "ano", pokud prispevek obsahuje 3 recenze,
     *  pokud ne, nastavi rozhodnuti na "ne".
     *  @param integer $prispevekID  ID prispevku
     *  @return boolean         Podarilo se nastavit rozhodnuti?
     */
    public function setRozhodnuti($prispevekID) {
        $q = "SELECT * FROM posudek
                WHERE posudek.id_prispevek=$prispevekID";
        $posudky = $this->executeQuery($q);
        $count = 0;
        foreach($posudky as $p) {
            if($p['originalita'] != 0 && $p['tema'] != 0 && $p['technicka_kvalita'] != 0 && $p['jazykova_kvalita'] != 0 && $p['doporuceni'] != 0) {
                $count++;
            }
        }
        if($count < 3) {
            $q1 = "UPDATE prispevek
                    SET rozhodnuti='ne'
                    WHERE id_prispevek = $prispevekID";
            $res = $this->executeQuery($q1);
            if($res == null){
                return false;
            } else {
                return true;
            }
        } else {
            $q1 = "UPDATE prispevek
                    SET rozhodnuti='ano'
                    WHERE id_prispevek = $prispevekID";
            $res = $this->executeQuery($q1);
            if($res == null){
                return false;
            } else {
                return true;
            }
        }
    }
    
    /**
    * Nastavi atribut 'post' prispevku na 'ano'.
    * @return boolean       Podarilo se zmenit post?
    */
    public function setPostPrispevek($prispevekID) {
        $q = "UPDATE prispevek
                SET post='ano'
                WHERE id_prispevek = $prispevekID";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Vraci vsechny posudky vsech recenzentu.
     * @return array        Pole se vsemi posudky vsech recenzentu nebo null.
     */
    public function vsechnyPosudky(){
        $q = "SELECT * FROM posudek";
        $res = $this->executeQuery($q);
        $res =$this->resultObjectToArray($res);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     *  Vrati dany posudek.
     *  @param integer $posudekID  ID posudku
     *  @return array         Pole s danym posudkem.
     */
    public function jedenPosudek($posudekID) {
        $q = "SELECT * FROM posudek
                WHERE id_posudek=$posudekID";
        $res = $this->executeQuery($q);
        if($res != null && count($res)>0){
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     * Vraci vsechny posudky autora.
     * @return array        Pole se vsemi posudky autora nebo null.
     */
    public function vsechnyPosudkyAutora($autor){
        $q = "SELECT * FROM posudek
                WHERE autor = '$autor'";
        $res = $this->executeQuery($q);
        $res =$this->resultObjectToArray($res);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     *  Vytvori v databazi novy posudek.
     *
     *  @return boolean         Podarilo se posudek vytvorit?
     */
    public function pridatPosudek($autor, $originalita, $tema, $technicka, $jazykova, $doporuceni, $poznamky, $prispevekID) {
        $stmt = $this->db->prepare("INSERT INTO posudek(autor,originalita,tema,technicka_kvalita,jazykova_kvalita,doporuceni,poznamky,id_prispevek)
                VALUES(:autor,:originalita,:tema,:technicka,:jazykova,:doporuceni,:poznamky,:prispevekID)");
        
        $au = $autor;
        $or = $originalita;
        $te = $tema;
        $tech = $technicka;
        $ja = $jazykova;
        $do = $doporuceni;
        $po = $poznamky;
        $pr = $prispevekID;
        
        $stmt->bindParam(':autor', $au);
        $stmt->bindParam(':originalita', $or);
        $stmt->bindParam(':tema', $te);
        $stmt->bindParam(':technicka', $tech);
        $stmt->bindParam(':jazykova', $ja);
        $stmt->bindParam(':doporuceni', $do);
        $stmt->bindParam(':poznamky', $po);
        $stmt->bindParam(':prispevekID', $pr);
        
        $stmt->execute();
        
        return true;
    }
    
    /**
     *  Upravi dany posudek.
     *  @param integer $originalita  originalita u posudku
     *  @param integer $tema  tema u posudku
     *  @param integer $tech  technicka kvalita u posudku
     *  @param integer $jaz  jazykova kvalita u posudku
     *  @param integer $doporuceni  doporuceni u posudku
     *  @param string $poznamky  poznamky u posudku
     *  @param integer $posudekID  ID posudku
     *  @return boolean         Podarilo se?
     */
    public function upravitPosudek($originalita, $tema, $technicka, $jazykova, $doporuceni, $poznamky, $posudekID) {
        $stmt = $this->db->prepare("UPDATE posudek
                SET originalita = :originalita, tema = :tema, technicka_kvalita = :technicka, jazykova_kvalita = :jazykova, doporuceni = :doporuceni, poznamky = :poznamky
                WHERE id_posudek = $posudekID");
        
        $or = $originalita;
        $te = $tema;
        $tech = $technicka;
        $ja = $jazykova;
        $do = $doporuceni;
        $po = $poznamky;
        
        $stmt->bindParam(':originalita', $or);
        $stmt->bindParam(':tema', $te);
        $stmt->bindParam(':technicka', $tech);
        $stmt->bindParam(':jazykova', $ja);
        $stmt->bindParam(':doporuceni', $do);
        $stmt->bindParam(':poznamky', $po);
        
        $stmt->execute();
        
        return true;
    }
    
    /**
     *  Smaze dany posudek z databaze.
     *  @param integer $prispevekID  ID posudku
     *  @return boolean         Podarilo se?
     */
    public function smazatPosudek($posudekID){
        $q = "DELETE FROM posudek
                WHERE id_posudek=$posudekID";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     *  Overi, zda dany uzivatel ma dane heslo.
     *  @param string $login  Login uzivatele.
     *  @param string $pass     Heslo uzivatele.
     *  @return boolean         Jsou hesla stejna?
     */
    public function isPasswordCorrect($login, $pass){
        $usr = $this->allUserInfo($login);
        if($usr==null){ // uzivatel neni v DB
            return false;
        }
        return password_verify($pass, $usr["heslo"]);
//        return $usr["heslo"]==$pass; // je heslo stejne?
    }

    /**
     *  Overi heslo uzivatele a pokud je spravne, tak uzivatele prihlasi.
     *  @param string $login    Login uzivatele.
     *  @param string $pass     Heslo uzivatele.
     *  @return boolean         Podarilo se prihlasit.
     */
    public function userLogin($login, $pass){
        if(!$this->isPasswordCorrect($login,$pass)){// neni heslo spatne?
            return false; // spatne heslo
        }
        // ulozim uzivatele do session
        $_SESSION["user"] = $this->allUserInfo($login);
        return true;
    }

    /**
     *  Odhlasi uzivatele.
     */
    public function userLogout(){
        // odstranim session
        session_unset($_SESSION["user"]);
    }

    /**
     *  Je uzivatel prihlasen?
     */
    public function isUserLogged(){
        return isset($_SESSION["user"]);
    }

    /**
     *  Vytvori v databazi noveho uzivatele.
     *
     *  @return boolean         Podarilo se uzivatele vytvorit
     */
    public function addNewUser($login,$jmeno, $heslo, $email, $idPrava){
        $stmt = $this->db->prepare("INSERT INTO uzivatele(login,jmeno,heslo,email,idprava)
                VALUES (:login,:jmeno,:heslo,:email,:idPrava)");
        
        $lo = $login;
        $jm = $jmeno;
        $he = $heslo;
        $em = $email;
        $id = $idPrava;
        
        $stmt->bindParam(':login', $lo);
        $stmt->bindParam(':jmeno', $jm);
        $stmt->bindParam(':heslo', $he);
        $stmt->bindParam(':email', $em);
        $stmt->bindParam(':idPrava', $id);
        
        $stmt->execute();
        
        return true;
    }

    /**
     *  Upravi informace o danem uzivateli.
     *  ... vse potrebne ...
     *  @return boolean         Podarilo se data upravit?
     */
    public function updateUserInfo($userId, $jmeno, $heslo, $email, $idPrava){
        $stmt = $this->db->prepare("UPDATE uzivatele
                SET jmeno=:jmeno, heslo=:heslo, email=:email, idprava=:idPrava 
                WHERE iduzivatel=$userId");
        
        $jm = $jmeno;
        $he = password_hash($heslo, PASSWORD_DEFAULT);;
        $em = $email;
        $id = $idPrava;
        
        $stmt->bindParam(':jmeno', $jm);
        $stmt->bindParam(':heslo', $he);
        $stmt->bindParam(':email', $em);
        $stmt->bindParam(':idPrava', $id);
        
        $stmt->execute();
        
        return true;
    }
    
    /**
     *  Upravi informace o pravu daneho uzivatele.
     *  ... vse potrebne ...
     *  @return boolean         Podarilo se data upravit?
     */
    public function updateUserInfoRight($userId, $idPrava){
        $stmt = $this->db->prepare("UPDATE uzivatele
                SET idprava=:idPrava 
                WHERE iduzivatel=$userId");
        
        $id = $idPrava;
        
        $stmt->bindParam(':idPrava', $id);
        
        $stmt->execute();
        
        return true;
    }

    /**
     *  Smaze daneho uzivatele z databaze.
     *  @param integer $userId  ID uzivatele.
     *  @return boolean         Podarilo se?
     */
    public function deleteUser($userId){
        $q = "DELETE FROM uzivatele
                WHERE iduzivatel=$userId";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }


}



?>