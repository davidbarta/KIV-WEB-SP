<?php 
    $title = "Správa uživatelů";
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
    } else { // je prihlasen
        //print_r($_SESSION["user"]);
        if($_SESSION["user"]["idprava"]!=1){ // neni admin
   ///////////// PRO PRIHLASENE UZIVATELE - NENI ADMIN ///////////////                
?>
        <b>Správu uživatelů mohou provádět pouze uživatelé s právem Administrátor.</b>
<?php
   ///////////// KONEC: PRO PRIHLASENE UZIVATELE - NENI ADMIN ///////////////                
        } else { // je admin
   ///////////// PRO PRIHLASENE UZIVATELE - JE ADMIN ///////////////                            
            // zpracovani odeslanych formularu
            if(isset($_POST["potvrzeni"]) && isset($_POST["user-id"])){
                // zadost o smazani uzivatele
                if($_POST["user-id"]!=""){
                    $res = $PDOObj->deleteUser($_POST["user-id"]);
                    if($res){
                        echo "<b>Uživatel s ID:".$_POST["user-id"]." byl smazán.</b><br><br>";
                    } else {
                        echo "<b>Uživatele s ID:".$_POST["user-id"]." se nepodařilo smazat!</b><br><br>";
                    }
                } else {
                    echo "<b>Neznámé ID uživatele. Mazání nebylo provedeno!</b><br><br>";
                }
            }
            
            $users = $PDOObj->allUsersInfo(); // vsichni uzivatele
            if(count($users) > 1) {
?>
                <b>Seznam uživatelů</b>
                <table class="table table-striped">
                    <thead class="myThead">
                        <tr><th>ID</th><th>Login</th><th>Jméno</th><th>E-mail</th><th>Právo</th><th>Akce</th></tr>
                    </thead>
<?php  
                
                foreach($users as $u){
                    if($u["iduzivatel"]!=$_SESSION["user"]["iduzivatel"]){ // aktualni uzivatele nevypisuju
                        echo "<tr><td>$u[iduzivatel]</td><td>$u[login]</td><td>$u[jmeno]</td><td>$u[email]</td><td>$u[nazev]</td>
                                <td>
                                    <a class='btn btn-default' href='index.php?page=13&uzivatel=$u[iduzivatel]'>Upravit</a>
                                </td>
                              </tr>";
                    }
                }
?>            
                </table>        
<?php

   ///////////// KONEC: PRO PRIHLASENE UZIVATELE - JE ADMIN ///////////////                
            } else {
                echo "<b>Nebyl nalezen žádný jiný registrovaný uživatel!</b><br><br>";
            }
        }
    }
?>

<?php
    // paticka
    foot();
?>
             