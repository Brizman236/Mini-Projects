<?php

# Function that display mangas from database to the array
function display($db){
    $query = 'SELECT * FROM `mangas`';
    $count = 1;
    if($result = mysqli_query($db, $query)){
        while($array = mysqli_fetch_assoc($result)){

            echo "
            <tr>
                <th scope='row'>".$count."</th>
                    <td>".$array['title']."</td>
                    <td>".$array['author']."</td>
                    <td>".$array['type']."</td>
                    <td class='d-flex gap-1'>
                        <form action='readMore.php' method='get'>
                            <button type='submit' name='read' class='bg-primary text-white border border-none rounded-2 ' value='".$array['id']."'>En savoir plus</button>
                        </form>

                        <form action='edit.php' methode='get'>
                            <button type='submit' name='edit' class='bg-warning text-white border border-none rounded-2' value='".$array['id']."'>Modifier</button>
                        </form>
                        <form method='post'>
                            <button type='submit' name='delete' class='bg-danger text-white border border-none rounded-2' value='".$array['id']."'>Supprimer</button>
                        </form>
                    </td>
                </tr>
            ";
            $count++;
        }
    }
    
}

# Function that adds manga in database
function add_book($db){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $type = $_POST['type'];
    $desc = $_POST['desc'];

    $query = "INSERT INTO `mangas`(title, author, type, description) VALUES ('$title', '$author', '$type', '$desc')";
    if(mysqli_query($db, $query) == false){
        echo"<span class='p-3 rounded-2 border border-danger bg-danger bg-opacity-25 text-danger'>Adding failed. Please retry...</span>";
    } else {
        echo "<span class='p-3 rounded-2 border border-success bg-success bg-opacity-25 text-success'>Manga added successfuly</span>";
    }

}

# Function that delete manga
function delete($db){
    $id = $_POST['delete'];
    $query = "DELETE FROM `mangas` WHERE id=".$id."";
    if(!mysqli_query($db, $query)){
        $message = "
            <div class='row'>
                <span class='p-3 rounded-2 border border-danger bg-danger bg-opacity-25 text-danger'>Adding failed. Please retry...</span>
            </div>
        ";
    } else {
        $message = "
            <div class='row'>
                <span class='p-3 rounded-2 border border-success bg-success bg-opacity-25 text-success'>Manga added successfuly</span>
            </div>
        ";
    }
    return $message;
}

# Function that redirect to the readmore page
function readMore($db, $id){
    $query = "SELECT * FROM `mangas` WHERE id=".$id;
    if($result = mysqli_query($db, $query)){
        $manga = mysqli_fetch_assoc($result);
        echo "
        <div class='row'>
            <div class='fw-bolder fs-4'>Title</div>
            <span class='fs-6'>".$manga['title']."</span>
        </div>

        <div class='row'>
            <div class='fw-bolder fs-4'>Description</div>
            <span class='fs-6'>".$manga['description']."</span>
        </div>

        <div class='row'>
            <div class='fw-bolder fs-4'>Author</div>
            <span class='fs-6'>".$manga['author']."</span>
        </div>

        <div class='row'>
            <div class='fw-bolder fs-4'>Type</div>
            <span class='fs-6'>".$manga['type']."</span>
        </div>
        ";
    }
}

# Function that edits the manga
function edit($db){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $type = $_POST['type'];
    $desc = $_POST['desc'];
    $id = $_POST['edit_manga'];
    $query = "UPDATE mangas set title = '$title', author = '$author', type = '$type', description = '$desc' WHERE id='$id'";
    mysqli_query($db, $query);
}

# Main function
function main($db){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        if (isset($_POST['add'])){
            header('Location: add.php');
            exit;
        }

        if (isset($_POST['submit_manga'])){
            add_book($db);
        }

        if (isset($_POST['back'])){
            header('Location: index.php');
            exit;
        }

        if (isset($_POST['delete'])){
            delete($db);
            header('Location: index.php');
            exit;
        }

        if(isset($_POST['edit_manga'])){
            edit($db);
            header('Location: index.php');
            exit;
        }
    }

}
?>