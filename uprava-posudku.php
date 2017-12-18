<?php 
    $title = "Úprava posudku";
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
        $jedenPosudek = $PDOObj->jedenPosudek($_GET["posudek"]);
        $posudek = "";
        foreach($jedenPosudek as $p) {
            $posudek = $p;
        }
        $jedenPrispevek = $PDOObj->jedenPrispevek($posudek["id_prispevek"]);
        $prispevek = "";
        foreach($jedenPrispevek as $p) {
            $prispevek = $p;
        }
        $odkaz = $prispevek["pdf_soubor"];
        
        if(isset($_POST['potvrzeni'])){
            $res = $PDOObj->upravitPosudek($_POST["originalita"], $_POST["tema"], $_POST["tech"], $_POST["jaz"], $_POST["doporuceni"], $_POST["poznamky"], $posudek["id_posudek"]);
            if($res){
                echo "<strong>Příspěvek byl úspěšně upraven.<br><br><strong>";
            } else {
                echo "<strong>Příspěvek se nepodařilo upravit!<br><br><strong>";
            }
        }
?>
    <form action="" method="POST">
        <div class="col-md-6">
       
            <div class="form-group">
                <label for="nazevPrispevku">Název příspěvku</label>
                <p id="nazevPrispevku"><strong><?php echo $prispevek["nazev"] ?></strong></p>
            </div>
            
            <div><a target="_blank" href="pdf/<?php echo $odkaz ?>">Stáhnout příspěvek</a></div>
            
            <div class="form-group">
                <label for="originalita">Originalita*</label>
                <select id="originalita" name="originalita" class="form-control">
                   <option value="1">1 = výborná</option>
                    <option value="2">2 = chvályhodná</option>
                    <option value="3">3 = dobrá</option>
                    <option value="4">4 = dostačující</option>
                    <option value="5">5 = nedostačující</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tema">Téma*</label>
                <select id="tema" name="tema" class="form-control">
                   <option value="1">1 = výborné</option>
                    <option value="2">2 = chvályhodné</option>
                    <option value="3">3 = dobré</option>
                    <option value="4">4 = dostačující</option>
                    <option value="5">5 = nedostačující</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tech">Technická kvalita*</label>
                <select id="tech" name="tech" class="form-control">
                   <option value="1">1 = výborná</option>
                    <option value="2">2 = chvályhodná</option>
                    <option value="3">3 = dobrá</option>
                    <option value="4">4 = dostačující</option>
                    <option value="5">5 = nedostačující</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="jaz">Jazyková kvalita*</label>
                <select id="jaz" name="jaz" class="form-control">
                   <option value="1">1 = výborná</option>
                    <option value="2">2 = chvályhodná</option>
                    <option value="3">3 = dobrá</option>
                    <option value="4">4 = dostačující</option>
                    <option value="5">5 = nedostačující</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="doporuceni">Doporučení*</label>
                <select id="doporuceni" name="doporuceni" class="form-control">
                   <option value="1">1 = určitě ano</option>
                    <option value="2">2 = spíše ano</option>
                    <option value="3">3 = neutrální</option>
                    <option value="4">4 = spíše ne</option>
                    <option value="5">5 = určitě ne</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="poznamky">Abstract*</label>
                <textarea id="poznamky" class="form-control" rows="5" name="poznamky" placeholder="Poznámky" required><?php echo $posudek["poznamky"] ?></textarea>
            </div>
        
            <div>
                <p>* Povinné položky</p>
                <input class="btn btn-default myButton1" type="submit" name="potvrzeni" value="Uložit">
                <a class="btn btn-default myButton1" href="index.php?page=7">Zpět</a>
            </div>
        </div>
    </form>
<?php
    }
?>

<?php
    // paticka
    foot();
?>