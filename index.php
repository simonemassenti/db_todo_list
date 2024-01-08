<?php
//vado ad utilizzare il file login.php per poter utilizzare la funzione login
require_once __DIR__ . "/login.php";

//se la sessione non è settata la faccio partire
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

//Effettuiamo l'operazione di login quando vengono passati i dati 
if (isset($_POST['username']) && isset($_POST['password'])) {
    //passiamo i valori ricevuti tramite post alla funzione login
    login($_POST['username'], $_POST['password'], $connection);
}

if (!empty($_SESSION['user_id']) && !empty($_SESSION['username'])) {
    //Una volta effettuato il login possiamo creare la query 
    $sql = "SELECT `users`.`username`, `todos`.`title`, `todos`.`description`, `todos`.`id`, `todos`.`done` FROM `todos` JOIN `users` ON `users`.`id`=`todos`.`user_id` WHERE `users`.`id` =" . $_SESSION['user_id'];

    $results = $connection->query($sql);

    $connection->close();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List (To-Li)</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include __DIR__ . "/partials/header.php" ?>

    <div class="container my-5">
        <!-- Se l'utente non è loggato vedrà il form di login -->
        <?php if (!empty($_SESSION['user_id']) && !empty($_SESSION['username'])) { ?>
            <div class="row">
                <!-- Add a todo -->
                <div class="col-4">
                    <?php if (isset($_GET['modify']) && $_GET['modify'] == "success") { ?>
                        <div class="card mx-auto my-2">
                            <div class="card-body">
                            <h5 class="card-title">Modifica Todo</h5>
                                <form action="modified.php" method="POST">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Titolo ToDo</label>
                                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $_GET['title']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descrizione</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $_GET['description']; ?></textarea>
                                    </div>
                                    <input type="hidden" type="text" name="id" value="<?php echo $_GET['id']; ?>">
                                    <button type="submit" class="btn btn-warning">Modifica</button>
                                    <a class="btn btn-danger" href="index.php?modify=cancel">Annulla</a>
                                </form>
                            </div>

                        </div>

                    <?php } else { ?>
                        <?php include __DIR__ . "/partials/new_todo.php" ?>
                        <?php if (isset($_GET['title']) && $_GET['title'] == "void") { ?>
                            <small class="text-danger">Il todo è vuoto!</small>
                        <?php } ?>
                    <?php } ?>
                </div>
                <!-- /Add a todo -->
                <div class="col-7 overflow-auto my-todos">
                    <!-- Visualizza i TODO  -->
                    <?php if ($results && $results->num_rows > 0) { ?>
                        <?php while ($row = $results->fetch_assoc()) { ?>
                            <ul class="list-group my-2">
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <!-- Title -->
                                        <h3 class="<?php if ($row['done']) {
                                                        echo 'text-decoration-line-through';
                                                    } ?>">
                                            <?php echo $row['title']; ?>
                                        </h3>
                                        <!-- Buttons -->
                                        <div class="d-flex">
                                            <!-- modify button -->
                                            <form class="me-2" action="modify_todo.php" method="POST">
                                                <input type="hidden" type="text" value="<?php echo $row['id'] ?>" name="id">
                                                <button type="submit" class="btn btn-secondary">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </form>


                                            <!-- Done button -->
                                            <form class="me-2" action="toggle_done.php" method="POST">
                                                <input type="hidden" type="text" value="<?php echo $row['done'] ?>" name="done">
                                                <input type="hidden" type="text" value="<?php echo $row['id'] ?>" name="id">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fa-regular fa-square-check"></i>
                                                </button>
                                            </form>
                                            <!-- Delete button -->
                                            <form action="delete_todo.php" method="POST">
                                                <input type="hidden" type="text" value="<?php echo $row['id'] ?>" name="id">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <!-- /Buttons -->
                                    </div>
                                    <!-- Description -->
                                    <?php if (strlen($row['description']) > 0) { ?>
                                        <ul class="list-group mt-2">
                                            <li class="list-group-item <?php if ($row['done']) {
                                                                            echo 'text-decoration-line-through';
                                                                        } ?>">
                                                <?php echo $row['description']; ?>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </li>
                            </ul>
                        <?php } ?>
                    <?php } else { ?>
                        La lista è vuota! Aggiungi la tua prima cosa da fare!
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <h1 class="text-center">Todo List (To-Li)</h1>
            <?php if (isset($_GET['logout']) && $_GET['logout'] === "success") { ?>
                <div class="alert alert-success w-50 mx-auto">Logout effettuato con successo!</div>
            <?php } ?>

            <?php if (isset($_GET['registration']) && $_GET['registration'] === "success") { ?>
                <div class="alert alert-success w-50 mx-auto">Registrazione avvenuta con successo!</div>
            <?php } ?>

            <div class="card w-50 mx-auto">
                <div class="card-body">
                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Accedi</button>
                        <a href="register.php" class="btn btn-warning ms-2">Registrati</a>
                    </form>

                </div>

            </div>

        <?php } ?>
    </div>

</body>

</html>