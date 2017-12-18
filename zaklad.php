<?php 
// zaklad stranky

/**
 *  Vytvoreni hlavicky stranky.
 *  @param string $title Nazev stranky.
 */
function head($title=""){
 
    // načtení souboru s funkcemi
    include("database.class.php");
    $PDOObj = new Database();
?>
<!doctype>
<html lang="cs">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?php echo $title; ?></title>

        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="css/styles.css">
    </head>
    <body>


        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php?page=0">Home</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-left">
                            <!--                            <li><a href="index.php?page=0">Login/Logout</a></li>-->
                            <!--                            <li><a href="index.php?page=3">Sprava osobních údajů</a></li>-->
                            <!--                            <li><a href="index.php?page=4">Sprava uživatelů</a></li>-->
                            
                            
<?php
                        if($PDOObj->isUserLogged()) {
                            if($_SESSION["user"]["idprava"] == 3) {
                                ?><li><a href="index.php?page=5">Seznam příspěvků</a></li><?php
                            }
                            if($_SESSION["user"]["idprava"] == 2) {
                                ?><li><a href="index.php?page=7">Příspěvky k posouzení</a></li><?php
                            }
                            if($_SESSION["user"]["idprava"] == 1) {
                                ?><li><a href="index.php?page=10">Seznam příspěvků</a></li><?php
                            }
                        }
?>    
                        </ul>
                        <ul class="nav navbar-nav navbar-right">

<?php
                        if($PDOObj->isUserLogged()) {
    // je uzivatel prihlasen?
        
                            if($_SESSION["user"]["idprava"] == 1) {
        // je uzivatel administrator?
?>      
                                <li><a href="index.php?page=4">Správa uživatelů</a></li>
<?php
                            }
?>   
                            <li><a href="index.php?page=3">Správa osobních údajů</a></li>
                            <li><a href="index.php?page=1"><?php echo"Přihlášen: ".$_SESSION["user"]["jmeno"]?></a></li>
    
<?php
                        } else {
?>
                            <li><a href="index.php?page=1">Přihlásit</a></li>   
<?php
                        }
                        if(!$PDOObj->isUserLogged()) {
    // je uzivatel prihlasen?
?>
                           <li><a href="index.php?page=2">Registrace</a></li>
<?php
                        }
?>
                       </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

            <h1><?php echo $title; ?></h1>

            <div>
                        
 <?php                       
      return $PDOObj;                  
}

/**
 *  Vytvoreni paticky.
 */
function foot(){
                ?>                
            </div>
            
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>


<?php

}


/**
 *  Vytvori selectbox s pravy uzivatelu.
 *  @param array $rights    Vsechna dostupna prava.
 *  @param integer $selected    Zvolena polozka nebo null.
 *  @return string          Vytvoreny selectbox.
 */
function createSelectBox($rights,$selected){
    $res = '<select class="form-control" name="pravo">';
    $r = $rights[0];
    foreach($rights as $r){
        if($selected == 1) {
            if($selected!=null && $selected==$r['idprava']){ // toto bylo ve stupu
                $res .= "<option value='".$r['idprava']."' selected>$r[nazev]</option>";    
            } else { // nemam vstup
                $res .= "<option value='".$r['idprava']."'>$r[nazev]</option>";    
            }
        } else if($selected == 2){
            if($r['idprava'] == 2) {
                if($selected!=null && $selected==$r['idprava']){ // toto bylo ve stupu
                    $res .= "<option value='".$r['idprava']."' selected>$r[nazev]</option>";    
                } else { // nemam vstup
                    $res .= "<option value='".$r['idprava']."'>$r[nazev]</option>";   
                }
            }
        } else {
            if($r['idprava'] == 3) {
                if($selected!=null && $selected==$r['idprava']){ // toto bylo ve stupu
                    $res .= "<option value='".$r['idprava']."' selected>$r[nazev]</option>";    
                } else { // nemam vstup
                    $res .= "<option value='".$r['idprava']."'>$r[nazev]</option>";    
                }
            }
        }
    }
    $res .= "</select>";
    return $res;
}
?>