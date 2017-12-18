<?php 
    $title = "Seznam příspěvků";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>

<?php
    if(!$PDOObj->isUserLogged()) {
    // je uzivatel prihlasen?
?>
    
    <b>Tato strána je dostupná pouze přihlášeným uživatelům.</b>
    
<?php
    } else {
        
        if(isset($_POST["potvrzeni"]) && isset($_POST["prispevek-id"])) {
            if($_POST["prispevek-id"] != "") {
            // neni ID prispevku prazdne?
                $tmp = $PDOObj->vsechnyPosudky();
                $bool = FALSE;
                foreach($tmp as $t){
                //projdu vsechny posudky a testuji, zda nemaji jako cizi klic ID mazaneho prispevku
                    if($_POST["prispevek-id"] === $t["id_prispevek"]){
                    //pokud ano, neprovedu mazani
                        $bool = TRUE;
                        break;
                    }
                }
                if(!$bool){
                //mazani prispevku
                    $res = $PDOObj->smazatPrispevek($_POST["prispevek-id"]);
                    if($res){
                        echo "<b>Příspěvek s ID:".$_POST["prispevek-id"]." byl smazán.</b><br><br>";
                    } else {
                        echo "<b>Příspěvek s ID:".$_POST["prispevek-id"]." se nepodařilo smazat!</b><br><br>";
                    }
                } else {
                //nemazu prispevek
                    echo "<b>Příspěvek s ID:".$_POST["prispevek-id"]." nemůže být smazán, má již přidělený posudek!</b><br><br>";
                }
            } else {
                echo "<b>Neznámé ID příspěvku. Mazání nebylo provedeno!</b><br><br>";
            }
        }
?>

<?php
        $prispevky = $PDOObj->vsechnyPrispevky();
        $prispevkyAutora = 0;
        foreach($prispevky as $p) {
            if($p["autor"] === $_SESSION["user"]["jmeno"] && $p["post"] != "ano"){
                $prispevkyAutora++;
            }
        }
        if($prispevkyAutora > 0) {
?>
    <table class="table table-striped">
        <thead>
            <tr><th>Název</th><th>Autor</th><th>Stav</th><th>Počet hodnocení</th><th>Vymazat</th></tr>
        </thead>
        <tbody>
        <?php
            $prispevky = $PDOObj->vsechnyPrispevky();
        
            if($prispevky != null) {
                foreach($prispevky as $p){
//                    echo $p["autor"];
//                    echo $_SESSION["user"]["jmeno"];
                    if($p["autor"] === $_SESSION["user"]["jmeno"] && $p["post"] != "ano"){
                        $hodnoceni = $PDOObj->hodnoceniPrispevku($p['id_prispevek']);
                        $hodnoceni = round($hodnoceni, 2);
                        if($hodnoceni == null) {
                            $hodnoceni = "Zatím nehodnoceno";
                        } else {
                            $hodnoceni = "Průměr ".$hodnoceni;
                        }
                        $posudkyPrispevku = $PDOObj->posudkyPrispevku($p['id_prispevek']);
                        $pocetHodnoceni = 0;
                        foreach($posudkyPrispevku as $pp) {
                            if($pp['originalita'] != 0 && $pp['tema'] != 0 && $pp['technicka_kvalita'] != 0 && $pp['jazykova_kvalita'] != 0 && $pp['doporuceni'] != 0) {
                                $pocetHodnoceni++;
                            }
                        }
                        echo "<tr><td><a href='index.php?page=8&action=edit&prispevek=$p[id_prispevek]'>$p[nazev]</a></td><td>$p[autor]</td>
                            <td>$hodnoceni</td>
                            <td>$pocetHodnoceni</td>
                            <td>
                                <form action='' method='POST'>
                                    <input type='hidden' name='prispevek-id' value='$p[id_prispevek]'>
                                    <button class='btn btn-default' type='submit' name='potvrzeni'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                </form>
                            </td></tr>";
                    }
                }
            }
        ?>
        </tbody>
    </table>
    
<?php
        } else {
            echo "<b>Přihlášený uživatel nemá žádné příspěvky!</b><br><br>";
        }
?>
    
    <a class="btn btn-default" href="index.php?page=6">Nový příspěvek</a>
    
<?php
    }
?>

<?php
    // paticka
    foot();
?>