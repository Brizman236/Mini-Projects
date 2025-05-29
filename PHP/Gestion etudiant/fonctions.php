<?php
    session_start();
    
    // Fonction pour rediriger sur le login si la session est efface
    function authbefore(){
        if(!(isset($_SESSION['login']) && isset($_SESSION['password']))){
            header('Location: login.php');
            exit();
        }
    } 
    
    
    // Fonction pour afficher l'erreur ou rediriger
    function redirection($bool){
        if (!$bool){
            echo "<span class='text-danger fw-bold'>Identifiants incorrects</span>";
        } else {
            header('Location: home.php');
            exit();
        }
    }
    // Fonction pour verifier le login et le mot de passe
    function login($liste, $login, $password){
        $auth = false;
        for($i = 0; $i < count($liste); $i++){
            if($login == $liste[$i]['login']){
                if($liste[$i]['password'] == $password){
                    $auth = true;
                    $_SESSION['login'] = $liste[$i]['login'];
                    $_SESSION['password'] = $liste[$i]['password'];
                }
            }
        redirection($auth);
        }
    }

    // Fonction pour recuperer la liste des utilisateurs
    function userList($con){
        $req = "SELECT * FROM `users`";
        $users = [];
        if($result = mysqli_query($con, $req)){
            while($row = mysqli_fetch_row($result)){
                $users[] = [
                    'login' => $row[0],
                    'password' => $row[1]
                ];
            }
        }
        return $users;
    }

    // Fonction pour detruire la session si le user se deconnecte 
    function logout(){
        if(isset($_POST['logout'])){
            // Détruire toutes les variables de session
            $_SESSION = array();
            
            // Détruire le cookie de session si il existe
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-3600, '/');
            }
            
            // Détruire la session
            session_destroy();
            
            // Rediriger vers la page de login
            header('Location: login.php');
            exit();
        }
    }
 

    // Fonction pour afficher les utilisateurs
    function display($con){
        $req = "SELECT * FROM `etudiant`";
        if($result = mysqli_query($con, $req)){
            while($row = mysqli_fetch_row($result)){
                echo "
                    <tr>
                        <th scope=\"row\">".$row[0]."</th>
                        <td>".$row[1]."</td>
                        <td>".$row[2]."</td>
                        <td>".$row[3]."</td>
                        <td>".$row[4]."</td>
                        <td>".$row[5]."</td>
                    </tr>                
                ";
            }
        }
    }

    // Fonction pour inserer les etudiants
    function insert($con){
            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age']) && isset($_POST['email']) && isset($_POST['tel'])){
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $age = $_POST['age'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
    
    
                $req = "INSERT INTO `etudiant`(`nom`, `prenom`, `age`, `email`, `tel`) VALUES ('$nom', '$prenom', '$age', '$email', '$tel')";
                if (mysqli_query($con, $req) == true){                   
                    echo "<span class='text-success'>Insertion Reussi </span>";
                } else {
                    echo "<span class='text-danger'> Echec de l'insertion </span>";
                }
            }
    }
?>