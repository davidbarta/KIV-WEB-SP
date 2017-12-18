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
            $bool = $PDOObj->setPostPrispevek($_POST["prispevek-id"]);
        }
        
        
        $prispevky = $PDOObj->vsechnyPrispevky();
        $count = 0;
        foreach($prispevky as $p) {
            if($p["post"] != "ano") {
                $count++;
            }
        }
        if($count > 0) {
?>
   
    <div class="col-md-8 col-lg-12">
        <table class="table table-striped">
            <thead>
                <tr><th>Název</th><th>Autor</th><th>Recenze</th><th>Rozhodnutí</th></tr>
            </thead>
            <tbody>
            <?php
                if($prispevky != null) {
                    foreach($prispevky as $p){
                        if($p["post"] != "ano") {
                            $PDOObj->setRozhodnuti($p['id_prispevek']);
                            $rozhodnuti = $p['rozhodnuti'];
                            $roz = "";
                            if($rozhodnuti == "ne") {
                                $roz = "Nepřijmuto";
                            } else {
                                $roz = "<form action='' method='POST'>
                                            <input type='hidden' name='prispevek-id' value='$p[id_prispevek]'>
                                            <button class='btn btn-default' type='submit' name='potvrzeni'>Přijmout</button>
                                        </form>";
                            }
                            echo "<tr>
                                <td>$p[nazev]</td>
                                <td>$p[autor]</td>
                                <td><a class='btn btn-default' href='index.php?page=11&prispevek=$p[id_prispevek]'>Upravit recenzi</a></td>
                                <td>$roz</td>
                                </tr>";
                        }
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
      
<?php
        } else {
            echo "<b>Nebyly nalezeny žádné příspěvky!</b><br><br>";
        }
    }
?>
<?php
    // paticka
    foot();
?>