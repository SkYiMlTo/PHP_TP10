<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP10_PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-light">

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./index.php">Accueil</a>
        </li>
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./viewadmin.php">Menu Admin</a>
        </li>
    </ul>

</nav>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <form action="controller.php?func=editEtu" method="post">
                <h1>Ajout étudiant</h1>

                <?php

                $conn = new PDO('pgsql:dbname=etudiants;host=127.0.0.1;port=5432', 'postgres', 'root');
                $query = "SELECT * FROM etudiant WHERE id = ?";
                $sth = $conn->prepare($query);
                $sth->execute(array($_POST['edit']));
                $sth = $sth->fetch();

                echo '
                <div class="form-group">
                    <label for="fname">Nom</label>
                    <input class="form-control" type="text" name="nom" value="'.$sth['nom'].'" required>
                </div>
                <div class="form-group">
                    <label for="name">Prenom</label>
                    <input class="form-control" type="text" name="prenom" value="'.$sth['prenom'].'" required>
                </div>
                <div class="form-group">
                    <label for="citation">Note</label>
                    <input class="form-control" type="text" name="note" value="'.$sth['note'].'" required>
                </div>
                <button type="submit" name="id" value="'.$_POST['edit'].'" class="btn btn-primary">Appliquer changements</button>
            </form>
            <br />
            <form action="controller.php?func=delEtu" method="post">
                <button type="submit" name="id" value="'.$_POST['edit'].'" class="btn btn-primary">Supprimer élève</button>
            </form>
                ';

                ?>

        </div>
    </div>
</div>

</body>
</html>

<?php



?>