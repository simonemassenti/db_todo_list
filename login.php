<?php

//qui controllo se nel database c'è la corrispondenza con nome utente e password

function login($username, $password, $connection){
    //se non è settata la sessione la starto
    if(!isset($_SESSION)){
        session_start();
    }

    //Utilizzo l'algoritmo di hash sulla password
    $hashed_password = md5($password);

    //utilizzo la prepared query per evitare l'SQL Injection
    $stmt = $connection->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");

    //ora dichiariamo cosa vogliamo mettere al posto dei placeholders
    $stmt->bind_param("ss", $username, $hashed_password);
    
    //eseguiamo l'interrogazione
    $stmt->execute();

    //recuperiamo il risultato
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
    } else {
        echo "Utente non registrato oppure username o password errati!";
    }
}