<?php

//Creo la connesione
define("DB_SERVER", "localhost: 3306"); //Porta del server
define("DB_USERNAME", "root"); //Username 
define("DB_PASSWORD", "root"); //Password
define("DB_NAME", "db_todo_list"); //Nome DB

//Connessione
$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Controllo se la connessione è fallita
if ($connection->connect_error) {
    echo "Connection failed";
    echo $connection->connect_error;
    die;
}

if(isset($_POST)) { 
    
    $stmt = $connection->prepare("UPDATE `todos` SET `title` = ?, `description` = ? WHERE `todos`.`id` = ?");

    $stmt->bind_param("ssi", $_POST["title"], $_POST["description"], $_POST["id"]);

    $stmt->execute();
}

header('Location: index.php');
?>