<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/mycss.css">
    <style>
        *{
            font-family: 'Roboto Mono';
        }
    </style>
</head>
<body>
    <?php
        require "connexions.php";  
        require "fonctions.php";
    ?>

    <div class="d-flex vh-100">
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center ">
            <div>
                <form class="d-flex flex-column gap-2 text-center border border-white rounded-5 p-5" method="post" autocomplete="off">
                    <div class="text-dark fs-5 fw-bold">Log In</div>
                    <input class="ipnt" type="" name="login" placeholder="Login : " required>
                    <input class="ipnt" type="" name="pass" placeholder="Password : " required>
                    <input class="ipnt bg-primary" type="submit" value="Connexion" name="submit">

                    <?php
                        // Recuperons l'entree de l'utilisateur
                        if(isset($_POST['submit'])){
                            // Recuperons la liste des utilisateurs
                            if(isset($_POST['login']) && isset($_POST['pass'])){
                                $users = userList($con);
                                $login = $_POST['login'];
                                $mdp = $_POST['pass'];
                                login($users, $login, $mdp);
                            }
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
