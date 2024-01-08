<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">To-Li</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">
                        <?php if (isset($_SESSION['username']) && $_SESSION['user_id']) { ?>
                            Ciao <?php echo $_SESSION['username']; ?>

                        <?php } ?>
                    </a>
                </li>
            </ul>
            <?php if (isset($_SESSION['username']) && $_SESSION['user_id']) { ?>

                <form action="logout.php" method="POST" class="ms-2">
                    <input type="hidden" type="text" value="1" name="logout">
                    <button type="submit" class="btn btn-danger">ESCI</button>
                </form>
            <?php } ?>


        </div>
    </div>
</nav>