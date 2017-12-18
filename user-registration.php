<?php 
    $title = "Registrace nového uživatele";
    // nacteni hlavicky stranky
    include("zaklad.php");
    $PDOObj = head($title);
?>

<?php
   // zpracovani odeslanych formularu
    if(isset($_POST['potvrzeni'])){ // nova registrace
        if($_POST["heslo"]==$_POST["heslo2"]){
            if($PDOObj->allUserInfo($_POST["login"])!=null){ // tento uzivatel uz existuje
                echo "<strong>Tento login už existuje. Zvolte si prosím jiný.</strong><br><br>";
            } else {
                $password = $_POST["heslo"];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $PDOObj->addNewUser($_POST["login"], $_POST["jmeno"], $hashed_password, $_POST["email"], $_POST["pravo"]);
                echo "<strong>Registrace se úspěšně povedla.<br><br><strong>";
                $PDOObj->userLogin($_POST["login"],$password);
                echo "<meta http-equiv='refresh' content='0'>";
            }
        } else {
            echo "<strong>Hesla nejsou stejná!</strong><br><br>";
        }
    }

    //odhlaseni uzivatele
    if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="logout"){
        $PDOObj->userLogout();
        echo "<meta http-equiv='refresh' content='0'>";
    }
    
   // je uzivatel aktualne prihlasen?
    if(!$PDOObj->isUserLogged()){ // neni prihlasen
   ///////////// PRO NEPRIHLASENE UZIVATELE ///////////////        
?>
        <strong>Registrační formulář</strong>
        <form action="" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla'">
            <table>
                <tr><td>Login:</td><td><input type="text" name="login" value="<?php echo @$_POST["login"]; ?>" required></td></tr>
                <tr><td>Heslo 1:</td><td><input type="password" name="heslo" id="pas1" required></td></tr>
                <tr><td>Heslo 2:</td><td><input type="password" name="heslo2" id="pas2" required></td></tr>
                <tr><td>Ověření hesla:</td><td><output name="x" for="pas1 pas2"></output></td></tr>
                <tr><td>Jméno:</td><td><input type="text" name="jmeno" value="<?php echo @$_POST["jmeno"]; ?>" required></td></tr>
                <tr><td>E-mail:</td><td><input type="email" name="email" value="<?php echo @$_POST["email"]; ?>" required></td></tr>
                <tr><td>Právo:</td>
                    <td><?php echo createSelectBox($PDOObj->allRights(),null); ?></td>
                </tr>
            </table>
            
            <input class="btn btn-default" type="submit" name="potvrzeni" value="Registrovat">
        </form>

<?php
   ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////
    } else { // je prihlasen
   ///////////// PRO PRIHLASENE UZIVATELE ///////////////                
?>
        <strong>Přihlášený uživatel se nemůže znovu registrovat.</strong>
        <!-- formular pro odhlaseni uzivatele -->
        <form action="" method="POST">
            <input type="hidden" name="action" value="logout">
            <input class="btn btn-default" type="submit" name="odhlaseni" value="Odhlásit">
        </form>
        
<?php
   ///////////// KONEC: PRO PRIHLASENE UZIVATELE ///////////////                
    }
?>

<?php
    // paticka
    foot();
?>
             