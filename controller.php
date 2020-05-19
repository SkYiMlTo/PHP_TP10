<?php
session_start();

function addUser()
{
    $conn = new PDO('pgsql:dbname=etudiants;host=127.0.0.1;port=5432', 'postgres', 'root');

    $maxIdRequest = $conn->query('SELECT MAX(id) FROM utilisateur');
    $maxid = $maxIdRequest->fetchAll();
    if ($maxid)
        $maxid = $maxid[0][0] + 1;
    else
        $maxid = 1;



    $modif = "
        insert into utilisateur (id, login, password, mail, nom, prenom)
        values (?,?,?,?,?,?);";
    $sqlRequest = $conn->prepare($modif);
    $sqlRequest->execute([$maxid, $_POST['login'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['mail'], $_POST['nom'], $_POST['prenom']]);
    header('Location: ./index.php');
}

function addEtu()
{
    $conn = new PDO('pgsql:dbname=etudiants;host=127.0.0.1;port=5432', 'postgres', 'root');

    $maxIdRequest = $conn->query('SELECT MAX(id) FROM etudiant');
    $maxid = $maxIdRequest->fetchAll();
    if ($maxid)
        $maxid = $maxid[0][0] + 1;
    else
        $maxid = 1;

    $modif = "
        insert into etudiant (id, user_id, nom, prenom, note)
        values (?,?,?,?,?);";
    $sqlRequest = $conn->prepare($modif);
    $sqlRequest->execute([$maxid, $_SESSION['__userSession']['idUser'], $_POST['nom'], $_POST['prenom'], $_POST['note']]);
    header('Location: ./viewadmin.php');
}

function login()
{
    $conn = new PDO('pgsql:dbname=etudiants;host=127.0.0.1;port=5432', 'postgres', 'root');
    $username = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT id, login, password FROM utilisateur WHERE utilisateur.login = ?";
    $sth = $conn->prepare($query);
    $sth->execute(array($username));
    $sth = $sth->fetchAll();
    $existUser = false;
    $userId = -1;
    if($sth) {
        foreach ($sth as $user) {
            if (password_verify($password, $user['password'])) {
                $existUser = true;
                $userId = $user['id'];
            }
        }
    }
    if($existUser){

        $arraySession = array(
            "idUser" => $userId
        );
        $_SESSION['__userSession']= $arraySession;
        header('Location: ./viewadmin.php');
    }
    else
        header('Location: ./viewlogin.php?loginError=true');

}

function editEtu()
{
    $conn = new PDO('pgsql:dbname=etudiants;host=127.0.0.1;port=5432', 'postgres', 'root');

    $query = "UPDATE etudiant SET nom = ?, prenom = ?, note = ? WHERE id = ?";
    $sth = $conn->prepare($query);
    $sth->execute(array($_POST['nom'], $_POST['prenom'], $_POST['note'], $_POST['id']));
    header('Location: ./viewadmin.php');
}

function delEtu()
{
    $conn = new PDO('pgsql:dbname=etudiants;host=127.0.0.1;port=5432', 'postgres', 'root');

    $query = "DELETE FROM etudiant WHERE id = ?;";
    $sth = $conn->prepare($query);
    $sth->execute(array($_POST['id']));
    header('Location: ./viewadmin.php');
}

if ($_GET['func'] == 'addUser') {
    addUser();
}
if ($_GET['func'] == 'addEtu') {
    addEtu();
}
if ($_GET['func'] == 'login') {
    login();
}
if ($_GET['func'] == 'editEtu') {
    editEtu();
}
if ($_GET['func'] == 'delEtu') {
    delEtu();
}

//    $query = "SELECT id, login, password FROM utilisateur WHERE login = $username";
//    $sth = $conn->prepare($query);
//    $sth->execute();
//    $sth = $sth->fetchAll();
//    print_r($sth);

//    if (password_verify('$passEntre', '$passHash')) {
//        header('Location: ./viewadmin.php');
//    } else {
//        $_POST['errorLogin'] = true;
//        header('Location: ./viewlogin.php?loginError=true');
//    }

?>


