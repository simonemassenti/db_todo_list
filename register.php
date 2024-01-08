<?php

if (isset($_POST["username"]) && $_POST["password"] && $_POST["rpassword"]) {
    if ($_POST['password'] === $_POST['rpassword']) {
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

        $hashed_password = md5($_POST['password']);

        $stmt = $connection->prepare("INSERT INTO `users`(`username`, `password`) VALUES (?, ?)");

        $stmt->bind_param("ss", $_POST["username"], $hashed_password);

        $stmt->execute();

        header("Location: index.php?registration=success");
    } else {
        header("Location: register.php?registration=failed");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione To-Li</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include __DIR__ . "/partials/header.php" ?>
    <h1 class="text-center">Registrati su To-Li</h1>
    <div class="container my-5">
        <?php if (isset($_GET['registration']) && $_GET['registration'] == "failed") { ?>
            
            <div class="alert alert-danger w-50 mx-auto" role="alert">
            Registrazione fallita! Le password non coincidono, ritenta!
            </div>
        <?php } ?>


        <div class="card w-50 mx-auto">

            <div class="card-body">
                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                        
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="rpassword" class="form-label">Ripeti Password</label>
                        <input type="password" class="form-control" id="rpassword" name="rpassword">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrati</button>
                    <a href="index.php" class="btn btn-danger ms-2">Annulla</a>
                </form>


            </div>

        </div>


    </div>
</body>

</html>