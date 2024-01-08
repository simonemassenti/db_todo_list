<?php
//Se la sessione non è settata la faccio partire
if(!isset($_SESSION)) {
    session_start();
}

//Controlliamo se è stato passato il valore 1 dal form di logout
if(isset($_POST['logout']) && $_POST['logout'] === "1") { 
    //distruggiamo la sessione e reindirizziamo a index.php
    session_destroy();
    header("Location: index.php?logout=success");
}
