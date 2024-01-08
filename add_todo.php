<?php
if (!isset($_SESSION)) {
    session_start();
}
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

if(isset($_POST) && (!empty(trim($_POST['title'])) || !empty(trim($_POST['description'])))) { 
    $stmt = $connection->prepare("INSERT INTO `todos`(`title`, `description`, `done`, `user_id`) VALUES (?, ?, 0, ?)");
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $stmt->bind_param("ssi", $title, $description, $_SESSION['user_id']);

    $stmt->execute();

    header('Location: index.php');
} else if(isset($_POST) && (empty(trim($_POST['title'])) || empty(trim($_POST['description'])))) {
    header('Location: index.php?title=void');
} else {
    echo "SEI QUA";
}


?>