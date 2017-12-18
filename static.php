<?php 
    $title = "Úvodní stránka";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>

<?php
    $prispevky = $PDOObj->vsechnyPrispevky();
    $count = 0;
    foreach($prispevky as $p) {
        if($p["post"] == "ano") {
            $count++;
        }
    }
    if($count > 0) {
?>

    <table class="table table-striped">
        <thead>
            <tr><th>Název</th><th>Autor</th><th>Abstract</th><th>Soubor</th></tr>
        </thead>
        <tbody>
        <?php
            if($prispevky != null) {
                foreach($prispevky as $p){
                    if($p["post"] == "ano") {
                        $odkaz = $p["pdf_soubor"];
                        echo "<tr><td>$p[nazev]</td><td>$p[autor]</td><td>$p[abstract]</td><td><a target='_blank' href='pdf/$odkaz'>Stáhnout příspěvek</a></td></tr>";
                    }
                }
            }    
        ?>
        </tbody>
    </table>

<?php
    } else {
        echo "<b>Nebyly nalezeny žádné publikované příspěvky.</b><br><br>";
    }
?>
<?php
    // paticka
    foot();
?>