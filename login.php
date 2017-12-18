<?php 
    $title = "Přihlášení a odhlášení uživatele";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>


<?php
   //// zpracovani odeslanych formularu
    // odhlaseni uzivatele
    if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="logout"){
        $PDOObj->userLogout();
        echo "<meta http-equiv='refresh' content='0'>";
    }
    // prihlaseni uzivatele
    if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="login"){
        $res = $PDOObj->userLogin($_REQUEST["login"],$_REQUEST["heslo"]);
        if(!$res){
//            echo "<div class'alert alert-danger' role='alert'>Přihlášení se nezdařilo!</div><br><br>";
            $result = "<div class='alert alert-warning alert-dismissible' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            <strong>Přihlášení neproběhlo v pořádku!</strong>
                        </div>";
            echo $result;
        } else {
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
    
    // je uzivatel aktualne prihlasen
    if(!$PDOObj->isUserLogged()){ // neni prihlasen
   ///////////// PRO NEPRIHLASENE UZIVATELE ///////////////        
?>
        <form action="" method="POST">
            <table>
                <tr><td>Login:</td><td><input type="text" name="login" required></td></tr>
                <tr><td>Heslo:</td><td><input type="password" name="heslo" required></td></tr>
            </table>
            <input type="hidden" name="action" value="login">
            <input class="btn btn-default" type="submit" name="potvrzeni" value="Přihlásit">
        </form>

<?php
   ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////
    } else { // je prihlasen
   ///////////// PRO PRIHLASENE UZIVATELE ///////////////                
?>
        <b>Přihlášený uživatel</b><br>
<?php echo "Jméno: ".$_SESSION["user"]["jmeno"]."<br>
            Login: ".$_SESSION["user"]["login"]."<br>
            E-mail: ".$_SESSION["user"]["email"]."<br>
            Právo: ".$_SESSION["user"]["nazev"]."<br>";
?>
        <br>
        
        Odhlášení uživatele:
        <form action="" method="POST">
            <input type="hidden" name="action" value="logout">
            <input class="btn btn-default" type="submit" name="potvrzeni" value="Odhlásit">
        </form>
        
        
        
<?php
   ///////////// KONEC: PRO PRIHLASENE UZIVATELE ///////////////                
    }
?>

<?php
    // paticka
    foot();
?>
             