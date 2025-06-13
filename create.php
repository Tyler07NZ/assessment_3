<!doctype html>
<html>
    <head>
        <title>Add new record</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>
    <body class="container">
        <?php
            // enable error reporting
            error_reporting(E_ALL);
            // display errors
            ini_set('display_errors', 1);
            include "connection.php";
            
            // when form is submitted prepare contents to send to database
            if(isset($_POST['create'])) {
                // prepare SQL statement to insert data
                $insert = $connection->prepare("INSERT INTO scp(item, class, containment, image, description) VALUES(?,?,?,?,?)");
                $insert->bind_param("sssss", $_POST['item'], $_POST['class'], $_POST['containment'], $_POST['image'], $_POST['description']);
                
                if($insert->execute()) {
                    echo "<p>Record successfully created.</p>";
                } else {
                    echo "<p>Error creating record: " . htmlspecialchars($insert->error) . ".</p>";
                }
            }
        ?>
        <h1>Add new record</h1>
        <p><a href="index.php" class="btn btn-primary">Back to index page</a></p>
        
        <form method="post" action="create.php" class="form-group">
            <label>Item</label>
            <br>
            <input type="text" name="item" placeholder="Enter Item" class="form-control">
            <br>
            <label>Class</label>
            <br>
            <input type="text" name="class" placeholder="Enter class" class="form-control">
            <br>
            <label>Containment</label>
            <br>
            <textarea name="containment" placeholder="Enter Containment" class="form-control"></textarea>
            <br>
            <label>Description</label>
            <br>
            <input type="text" name="description" placeholder="Enter Description" class="form-control">
            <br>
            <label>Image</label>
            <br>
            <input type="text" name="image" placeholder="e.g images/name_of_image.png" class="form-control">
            <br>
            <input type="submit" name="create" value="Add new record" class="btn btn-success">
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </body>
</html>
