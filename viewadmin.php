<?php
session_start();


?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>TP10_PHP</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
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
            <li class="nav-item">
                <a class="nav-link" href="./viewnewuser.php">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./viewlogin.php">Connexion</a>
            </li>
        </ul>

    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <h1>Bienvenue

                    <?php
                    $conn = new PDO('pgsql:dbname=etudiants;host=127.0.0.1;port=5432', 'postgres', 'root');
                    $query = "SELECT * FROM utilisateur WHERE utilisateur.id = ?";
                    $sth = $conn->prepare($query);
                    $sth->execute(array($_SESSION['__userSession']['idUser']));
                    $sth = $sth->fetch();

                    echo $sth['prenom'] . " " . $sth['nom'];
                    ?>

                </h1>

                <br />

                <h3>Liste de vos étudiants</h3>
                <table class="table">
                    <thead>
                    <tr>
                   <!--     <th scope="col">#</th> -->
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Note</th>
                        <th scope="col">Mise à jour</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php

                $query = "SELECT * FROM etudiant WHERE user_id = ?";
                $sth = $conn->prepare($query);
                $sth->execute(array($_SESSION['__userSession']['idUser']));
                $sth = $sth->fetchAll();
                foreach ($sth as $data){
                    echo '
                    <tr>
                    <!--    <th scope="row">1</th> -->
                        <td>'.$data['nom'].'</td>
                        <td>'.$data['prenom'].'</td>
                        <td>'.$data['note'].'</td>
                        <td>
                            <form action="./view-editetudiant.php" method="post">
                                <button type="submit" name="edit" value="'.$data['id'].'" class="btn btn-primary">Modifier</button>
                            </form>
                        </td>
                    </tr>
                ';
                }
                ?>
                    </tbody>
                </table>

                <form action="./view-newetudiant.php" method="post">
                    <button type="submit" class="btn btn-primary">Ajout étudiant</button>
                </form>

            </div>
        </div>
    </div>

    </body>
    </html>

<?php
//echo $_SESSION['__userSession']['idUser'] . "test";
//echo '';
?>