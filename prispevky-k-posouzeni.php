<?php 
    $title = "Seznam příspěvků k posouzení";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>
<?php
    $count = 0;
    $posudky = $PDOObj->vsechnyPosudky($_SESSION["user"]["jmeno"]);

    foreach($posudky as $pos) {
        if($pos['autor'] == $_SESSION["user"]["jmeno"]) {
            $prispevek = $PDOObj->jedenPrispevek($pos['id_prispevek']);
            foreach($prispevek as $p) {
                if($p["post"] != "ano") {
                    $count++;
                }
            }
        }
    }

    if($count > 0) {
?>
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
                <tr><th>Název</th><th>Ohodnocení</th></tr>
            </thead>
            <tbody>
            <?php
                
                if($posudky != null) {
                    foreach($posudky as $p) {
                        $prispevek = $PDOObj->jedenPrispevek($p['id_prispevek']);
                        $hodnoceni = $PDOObj->hodnoceniPrispevku($p['id_prispevek']);
                        $hodnoceni = round($hodnoceni, 2);
                        foreach($prispevek as $pr) {
                            if($pr["post"] != "ano") {
                                echo "<tr><td><a href='index.php?page=9&action=edit&posudek=$p[id_posudek]'>$pr[nazev]</a></td>
                                <td>$hodnoceni</td>
                                </tr>";
                            }
                        }
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
<?php
    } else {
        echo "<b>Přihlášený uživatel nemá nic k posouzení!</b><br><br>";
    }
?>

<?php
    // paticka
    foot();
?>