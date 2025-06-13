<!doctype html>
<html>
    <head>
        <title>SCP Foundation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>
    <body class="container">
        <?php 
            include "connection.php"; 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        ?>
        <h1>SCP Foundation</h1>
        <nav>
            <a href="index.php">Index Page</a>
            <?php foreach($result as $link): ?>
                <a href="index.php?link=<?php echo htmlspecialchars($link['item']); ?>"><?php echo htmlspecialchars($link['item']); ?></a>
            <?php endforeach; ?>
            <a href="create.php">Add new record</a>
        </nav>
        <div class="border rounded shadow p-3">
            <?php
                // Display record contents based on link get value
                if(isset($_GET['link'])) {
                    $class = $_GET['link'];
                    
                    // retrieve record from database using prepared statement
                    $stmt = $connection->prepare("SELECT * FROM scp WHERE class = ?");
                    $stmt->bind_param("s", $class);
                    $stmt->execute();
                    $record = $stmt->get_result();
                    
                    if($record->num_rows > 0) {
                        $array = $record->fetch_assoc();
                        $edit = "edit.php?edit=" . htmlspecialchars($array['id']);
                        $delete = "index.php?del=" . htmlspecialchars($array['id']);
                        
                        // display record fields on screen
                        echo "
                            <h1>" . htmlspecialchars($array['class']) . "</h1>
                            <h3>" . htmlspecialchars($array['containment']) . "</h3>
                            <p><img src='" . htmlspecialchars($array['image']) . "' alt='" . htmlspecialchars($array['class']) . "' class='img-fluid'></p>
                            <p>" . htmlspecialchars($array['description']) . "</p>
                            <p>
                                <a href='" . htmlspecialchars($edit) . "' class='btn btn-warning'>Edit Record</a> || <a href='" . htmlspecialchars($delete) . "' class='btn btn-danger'>Delete Record</a>
                            </p>
                        ";
                    } else {
                        echo "<p>No records found for class: " . htmlspecialchars($class) . "</p>";
                    }
                } else {
                    echo "<p>No class parameter provided.</p>";
                }

                if(isset($_GET['del'])) {
                    $ID = $_GET['del'];
                    $delete = $connection->prepare("DELETE FROM scp WHERE id = ?");
                    $delete->bind_param("i", $ID);
                    
                    if($delete->execute()) {
                        echo "<p>Record Deleted</p>";
                    } else {
                        echo "<p>Error: " . htmlspecialchars($delete->error) . "</p>";
                    }
                }
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </body>
</html>
