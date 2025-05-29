<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spaceland</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
    <?php
        require "connexions.php";
        require "fonctions.php";
        authbefore();
    ?>
    <div class="container-fluid">
        <div class="row justify-content-end">
            <form method="post">
                <button class="btn bg-primary" name="logout">Log Out</button>
            </form>
            <?php 
                logout();
            ?>
        </div>
        <div class="row">
            <div class="col-12 text-center my-4">
                <h1 class="display-4" style="color: #2c3e50;">Liste des Étudiants</h1>
                <p class="text-muted">Gestion des données étudiantes</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <div class="card">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prenom</th>
                                <th scope="col">Age</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                display($con); 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <form  method="post">
                <button class="bg-primary px-4 py-2 text-white border border-none rounded-5 " name='insert' type="submit">Inserer un etudiant</button>
            </form>
            <?php if (isset($_POST['insert'])){header('Location: insertion.php');};?>
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
