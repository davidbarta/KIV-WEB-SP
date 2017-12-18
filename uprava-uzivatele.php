<?php 
    $title = "Úprava uživatele";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>

<?php
    if(!$PDOObj->isUserLogged()){ // neni prihlasen
   ///////////// PRO NEPRIHLASENE UZIVATELE ///////////////        
?>
    <b>Tato strána je dostupná pouze přihlášeným uživatelům.</b>
<?php
   ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////
    } else {
            
        if(isset($_POST["smazat"])){
        // zadost o smazani uzivatele
            $uzivatelID = $_GET["uzivatel"];
            if($uzivatelID!=""){
                $res = $PDOObj->deleteUser($uzivatelID);
                if($res){
                    echo "<b>Uživatel s ID:".$uzivatelID." byl smazán.</b><br><br>";
                } else {
                    echo "<b>Uživatele s ID:".$uzivatelID." se nepodařilo smazat!</b><br><br>";
                }
            } else {
                echo "<b>Neznámé ID uživatele. Mazání nebylo provedeno!</b><br><br>";
            }
        }
        
        if(isset($_POST["potvrzeni"])) {
            $isChanged = $PDOObj->updateUserInfoRight($_GET["uzivatel"], $_POST["pravo"]);
            if($isChanged) {
                echo "<b>Osobní údaje byly změněny.</b><br><br>";
            } else {
                echo "<b>Osobní údaje se nepodařilo změnit!</b><br><br>";
            }
        }
?>
   
    <form method='POST'>
            <input class='btn btn-default myButton2' id='smazani' type='submit' name='smazat' value='Smazat uživatele'>
    </form>
    
    <form method="POST">
        
        <div class="form-group col-sm-6">
            <label for="upravaPrava">Úprava práva</label>
            <?php 
                echo createSelectBox($PDOObj->allRights(),1);
            ?>
        </div>
        
        <div class=" myButton2 myClear">
            <input class="btn btn-default" type="submit" name="potvrzeni" value="Uložit">
            <a class="btn btn-default" href="index.php?page=4">Zpět</a>
        </div>
        
    </form>
<?php
    }
?>
    
<?php
    // paticka
    foot();
?>