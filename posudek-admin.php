<?php 
    $title = "Přiřazování recenzí";
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
        $aktualniPrispevek = $_GET["prispevek"];
        $vsechnyPosudky = $PDOObj->posudkyPrispevku($aktualniPrispevek);
        $count = 0;
        
        if(isset($_POST["potvrzeni"]) && isset($_POST["posudek-id"])) {
            if($_POST["posudek-id"] != "") {
            // neni ID prispevku prazdne?
                //mazani prispevku
                $res = $PDOObj->smazatPosudek($_POST["posudek-id"]);
                echo "<meta http-equiv='refresh' content='0'>";
                if($res){
                    echo "<b>Posudek s ID:".$_POST["posudek-id"]." byl smazán.</b><br><br>";
                } else {
                    echo "<b>Posudek s ID:".$_POST["posudek-id"]." se nepodařilo smazat!</b><br><br>";
                }
            } else {
                echo "<b>Neznámé ID posudku. Mazání nebylo provedeno!</b><br><br>";
            }
        }
?>
       
    <div class="col-md-8 col-lg-12">
        <table class="table table-striped">
            <thead>
                <tr><th>Recenzent</th><th>Orig.</th><th>Téma</th><th>Tech.</th><th>Jaz.</th><th>Dop.</th><th>Celk.</th><th>Vymazat</th></tr>
            </thead>
            <tbody>
                <?php
                    if($vsechnyPosudky != null) {
                        $uzivatele = $PDOObj->allUsers();
                        foreach($vsechnyPosudky as $p) {
                            $count++;
                            echo "<tr>
                            <td>$p[autor]</td>
                            <td>$p[originalita]</td>
                            <td>$p[tema]</td>
                            <td>$p[technicka_kvalita]</td>
                            <td>$p[jazykova_kvalita]</td>
                            <td>$p[doporuceni]</td>
                            <td>$p[poznamky]</td>
                            <td>
                                <form action='' method='POST'>
                                    <input type='hidden' name='posudek-id' value='$p[id_posudek]'>
                                    <button class='btn btn-default' type='submit' name='potvrzeni'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                </form>
                            </td>
                            </tr>";
                        }
                    }
                    while($count < 3) {
                        echo "</select></td>
                        <td colspan='8' class='myColspan'><a class='btn btn-default' href='index.php?page=12&prispevek=$aktualniPrispevek'>Přiřadit k recenzi</a></td>
                        </tr>";
                        $count++;
                    }
                ?>
            </tbody>
        </table>
        <a class="btn btn-default" href="index.php?page=10">Zpět</a>
    </div>
        
<?php
    }
?>
<?php
    // paticka
    foot();
?>