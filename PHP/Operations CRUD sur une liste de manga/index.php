<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<?php
    require "connexion.php";
    require "functions.php";
    main($db);
?>
<body>
    <div class="container">

        <div class="row justify-content-between p-4 mb-4">
            <div class="col-9 fw-medium fs-4">Liste de Mangas</div>
            <div class="col">
                <form method="post">
                    <input type="submit" class='bg-primary text-white border border-none rounded-2 p-2' name='add' value="Ajouter un manga">
                </form>
            </div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php display($db); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>