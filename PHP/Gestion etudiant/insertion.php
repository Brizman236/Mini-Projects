<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/mycss.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>
<body>
    <?php
        require "connexions.php";
        require "fonctions.php";
        authbefore();
    ?>
<div class="d-flex vh-100">
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center ">
            <div>
                <form class="d-flex flex-column gap-2 text-center border border-white rounded-5 p-5" method="post" autocomplete="off">
                    <div class="text-dark fs-5 fw-bold">Inserer un etudiant</div>
                    <input class="ipnt" type="" name="nom" placeholder="Nom : " required>
                    <input class="ipnt" type="" name="prenom" placeholder="Prenom : " required>
                    <input class="ipnt" type="number" name="age" placeholder="Age : " required>
                    <input class="ipnt" type="email" name="email" placeholder="Email : " required>
                    <input class="ipnt" type="" name="tel" placeholder="Telephone : " required>
                    <input class="ipnt bg-primary" type="submit" value="Inserer" name="inserer">

                    <?php
                        if(isset($_POST['inserer'])){
                            insert($con);
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
