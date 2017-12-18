<?php 
    $title = "Přiřazení recenze";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>

<?php
    if(isset($_POST["potvrzeni"])) {
        $posudky = $PDOObj->posudkyPrispevku($_GET["prispevek"]);
        $isExisting = false;
        foreach($posudky as $p) {
            if($p["autor"] == $_POST["recenzent"]) {
                $isExisting = true;
                break;
            }
            $isExisting = false;
        }
        if(!$isExisting) {
            $PDOObj->pridatPosudek($_POST["recenzent"],0,0,0,0,0,"",$_GET["prispevek"]);
            echo "<strong>Recenze byla úspěšně přiřazena.<br><br><strong>";
        } else {
            echo "<strong>Tento příspěvek je již recenzován tímto autorem!<br>Zvolte prosím jiného autora.<br><br><strong>";
        }
        
    }
?>

<?php
    if(!$PDOObj->isUserLogged()) {
    // je uzivatel prihlasen?
?>
    
    <b>Tato strána je dostupná pouze přihlášeným uživatelům.</b>
    
<?php
    } else {
    $aktualniPrispevek = $_GET["prispevek"];
?>
    
    
       <form method="POST">
          <div class="col-md-4">
           <div class="form-group">
               <label for="recenzent">Recenzent</label>
               <select id="recenzent" name="recenzent" class="form-control">
                <?php
                    $uzivatele = $PDOObj->allUsers();
                    foreach($uzivatele as $u){
                        if($u["idprava"] == 2){
                            echo "<option value='".$u['jmeno']."'>$u[jmeno]</option>";
                        }
                    }
                ?>
               </select>
           </div>
           </div>
           <div class="myDiv">
               <input class="btn btn-default" type="submit" name="potvrzeni" value="Přiřadit">
           </div>
       </form>
        <?php
            echo "<a class='btn btn-default myButton' href='index.php?page=11&prispevek=$aktualniPrispevek'>Zpět</a>";
        ?>
    
    

<?php
    }
?>
<?php
    // paticka
    foot();
?>