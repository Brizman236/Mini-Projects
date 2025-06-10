<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

</head>
<body>
    <?php
        require "connexion.php";
        require "functions.php";
        
    ?>
    <div class="container">
        <div class="row justify-content-between p-4 mb-4">
            <div class="col-9 fw-medium fs-4">Ajout d'un manga</div>
            <div class="col">
                <form method="post">
                    <input type="submit" class='bg-primary text-white border border-none rounded-2 p-2' name='back' value="Retour">
                </form>
            </div>
        </div>
        <div class="row">
            <form method="post">
                <label for="title" class="form-label fw-semibold">Titre</label>
                <input name='title' type="text" id='title' class='form-control mb-3' required placeholder='Titre'>
                <label  for="author" class="form-label fw-semibold">Auteur</label>
                <input name='author' type="text" id='author' class='form-control mb-3' required placeholder='Auteur'>
                <label for="type" class="form-label fw-semibold">Type</label>

                <select id='type' name='type' class="form-select mb-3" required>
                    <option selected>Choisir le type</option>
                    <option value="Shōnen">Shōnen</option>
                    <option value="Shōjo">Shōjo</option>
                    <option value="Tensei">Tensei</option>
                    <option value="Seinen">Seinen</option>
                </select>
                <label for="desc" class="form-label fw-semibold">Description</label>
                <textarea name='desc' id='desc' class="form-control mb-3" rows="3" required></textarea>
                <input type="submit" class='bg-primary text-white border border-none rounded-2 p-2 mb-3' name='submit_manga' value="Add">
            </form>
        </div>
        <div class="row">
            <?php main($db);?>
        </div>
    </div>
</body>
</html>