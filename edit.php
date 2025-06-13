<!doctype html>
<html>
    <head>
        <title>Edit Record</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>
    <body class="container">
        <?php
            // enable error reporting
            error_reporting(E_ALL);
            // display errors
            ini_set('display_errors', 1);
            include "connection.php";
            
            // initialize empty array
            $row = [];
            
            // if directed from index page via edit link
            if(isset($_GET['edit'])) {
                $id = $_GET['edit'];
                
                // based on id select appropriate record from DB
                $recordToUpdate = $connection->prepare("SELECT * FROM scp WHERE id = ?");
                $recordToUpdate->bind_param("i", $id);
                
                if($recordToUpdate->execute()) {
                    echo "<p>Record ready for editing</p>";
                    $temp = $recordToUpdate->get_result();
                    $row = $temp->fetch_assoc();
                } else {
                    echo "<p>Error: " . htmlspecialchars($recordToUpdate->error) . "</p>";
                }
            }
        ?>
        <h1>Edit Record</h1>
        <p><a href="index.php" class="btn btn-primary">Back to index page</a></p>
        
        <form method="post" action="update.php" class="form-group">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <label>Item</label>
            <br>
            <input type="text" name="item" value="<?php echo htmlspecialchars($row['item']); ?>" class="form-control">
            <br>
            <label>Class</label>
            <br>
            <input type="text" name="class" value="<?php echo htmlspecialchars($row['class']); ?>" class="form-control">
            <br>
            <label>Containment</label>
            <br>
            <textarea name="containment" class="form-control"><?php echo htmlspecialchars($row['containment']); ?></textarea>
            <br>
            <label>Description</label>
            <br>
            <textarea name="description" class="form-control"><?php echo htmlspecialchars($row['description']); ?></textarea>
            <br>
            <label>Image</label>
            <br>
            <input type="text" name="image" value="<?php echo htmlspecialchars($row['image']); ?>" class="form-control">
            <br>
            <input type="submit" name="update" value="Edit record" class="btn btn-success">
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </body>
</html>
