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
    $sql = "SELECT `title`, `description` FROM `todos` WHERE `todos`.`id` =".$_POST['id'];
    var_dump($_POST['id']);
    $results = $connection->query($sql);

    $connection->close();

    $row = $results->fetch_assoc();
    
    var_dump($row['description']);

    header("Location: index.php?modify=success&title=".$row['title']."&description=".$row['description']."&id=".$_POST['id']);
}


?>