<!DOCTYPE html>
<html>

<head>
    <title>#BENJAMIN FERNANDEZ#</title>
    <?php require_once "requirements.php" ?>
</head>

<?php 
    require "pdo.php";
    require "util.php";
    session_start();

?>

<body>
    <h1>Benjamin's Resume Registry</h1>

    <?php
        flash();
        if ( isset($_SESSION['name'])) {
            echo "<a href='logout.php'>Logout</a><br />";
           
        } else {
            echo "<a href='login.php'>Please log in</a>";
        }

        $statement = $pdo->query("SELECT * FROM profile");

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row != false) {

            $statement = $pdo->query("SELECT * FROM profile");
            
            echo "<table border='1'>
            <tbody>
            <tr> 
            <th>Name</th>
            <th>Headline</th>";

            if (isset($_SESSION['name'])) {
                echo "<th>Action</th>";
            }
            
            echo "</tr>";
            while ( $row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td><a href='view.php?profile_id=".$row['profile_id']."'>".$row['first_name']." ".$row['last_name']."</a></td>";
                echo "<td>".$row['email']."</td>";
                if (isset($_SESSION['name'])) {
                    echo "<td>
                        <a href='edit.php?profile_id=".$row['profile_id']."'>Edit </a>
                        <a href='delete.php?profile_id=".$row['profile_id']."'>Delete</a>
                    </td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
        }
        

        if ( isset($_SESSION['name'])) {
            echo "<a href='add.php'>Add New Entry</a>";
        } 

    ?>
</body>

</html>