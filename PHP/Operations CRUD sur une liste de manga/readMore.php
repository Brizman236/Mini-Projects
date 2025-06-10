<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Readmore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>

    <?php
        require "connexion.php";
        require "functions.php";
        main($db);
    ?>
    <div class="container">
        <div class="row justify-content-between p-4 mb-4">
            <div class="col-9 fw-medium fs-4">Plus sur le manga</div>
            <div class="col">
                <form method="post">
                    <input type="submit" class='bg-primary text-white border border-none rounded-2 p-2' name='back' value="Retour">
                </form>
            </div>
    </div>
</div>
<?php if(isset($_GET['read'])):?>

    <?php
        $manga = NULL;
        $id = $_GET['read'];
        $query = "SELECT * FROM `mangas` WHERE id=".$id;
        if($result = mysqli_query($db, $query)){
            $manga = mysqli_fetch_assoc($result);
        }
    ?>
    <div class="container bg-secondary bg-opacity-25 d-flex flex-column gap-3 mt-4 py-3 px-5">
    <div class='row'>
            <div class='fw-bolder fs-4'>Title</div>
            <span class='fs-6'><?php echo $manga['title'] ?></span>
        </div>

        <div class='row'>
            <div class='fw-bolder fs-4'>Description</div>
            <span class='fs-6'><?php echo $manga['description'] ?></span>
        </div>

        <div class='row'>
            <div class='fw-bolder fs-4'>Author</div>
            <span class='fs-6'><?php echo $manga['author'] ?></span>
        </div>

        <div class='row'>
            <div class='fw-bolder fs-4'>Type</div>
            <span class='fs-6'><?php echo $manga['type'] ?></span>
        </div>
    </div>
<?php endif;?>
</body>
</html>