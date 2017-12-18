<?php 
    $title = "Nový příspěvek";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>

<?php
    if(isset($_POST['potvrzeni'])){
        $PDOObj->pridatPrispevek($_POST["nazev"], $_SESSION["user"]["jmeno"], $_POST["abstract"], $_POST["file"]);
        echo "<strong>Příspěvek byl úspěšně přidán.<br><br><strong>";
    }
?>

<?php
    if(!$PDOObj->isUserLogged()){ // neni prihlasen
   ///////////// PRO NEPRIHLASENE UZIVATELE ///////////////        
?>
        <b>Tato strána je dostupná pouze přihlášeným uživatelům.</b>
<?php
   ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////
    } else {
?>
    <form action="" method="POST">
        <div class="col-md-6">
                
            <div class="form-group">
                <label class="col-sm-2" for="nazevPrispevku">Název*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nazevPrispevku" placeholder="Název příspěvku" name="nazev" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="jmenoAutora">Autor</label>
                <div class="col-sm-10">
                    <p id="jmenoAutora"><strong><?php echo $_SESSION["user"]["jmeno"]?></strong></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="abstractPrispevku">Abstract*</label>
                <div class="col-sm-10">
                    <textarea id="abstractPrispevku" class="form-control" rows="3" name="abstract" placeholder="Abstract" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2">
                    <input id="input-b1" name="file" type="file" class="file myFileInput" required>
                </div>
            </div>
            
            <div class="col-sm-offset-2 myFormNovyPrispevek">
                <p>* Povinné položky</p>
                <input class="btn btn-default" type="submit" name="potvrzeni" value="Uložit">
                <a class="btn btn-default" href="index.php?page=5">Zpět</a>
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