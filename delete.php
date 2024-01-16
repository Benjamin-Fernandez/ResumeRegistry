<?php 

    require_once "pdo.php";
    session_start();

    if (isset($_POST['cancel'])) {
        header("Location: index.php");
        return;
    }

    if (isset($_POST['profile_id']) ) {

        $sql = "DELETE FROM profile WHERE profile_id = :pi";

        $statement = $pdo->prepare($sql);

        $statement->execute(array(
            ":pi" => $_POST['profile_id']
        ));

        $_SESSION['success'] = "Profile deleted";
        header("Location: index.php");
        return;

    }
    
    if (!isset($_GET['profile_id'])) {
        $_SESSION['error'] = "Could not load profile";
        header("Location: index.php");
        return;
    }
    
    $statement = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :profile_id");
    
    $statement->execute(array(
        ":profile_id" => $_GET["profile_id"],
    ));

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row == false) {
        $_SESSION['error'] = "Could not load profile";
        header("Location: index.php");
        return;
    }

    $first_name = htmlentities($row["first_name"]);
    $last_name = htmlentities($row["last_name"]);
    $email = htmlentities($row["email"]);
    $headline = htmlentities($row["headline"]);
    $summary = htmlentities($row["summary"]);
?>
<!DOCTYPE html>
<title>
<html>
<head> <title>#BENJAMIN FERNANDEZ#</title></head>

<body>

    <h1>Deleteing Profile </h1>

    <?php 
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
    ?>

    <p>
        First Name: <?php echo $first_name; ?>
    </p>
    <p>
        Last Name: <?php echo $last_name; ?>
    </p>

    <form method="POST">
        <p>
            <input type="hidden" name="profile_id" value="<?= $_GET['profile_id'] ?>" />
        </p>
        <input type="submit" name="delete" value="Delete" />
        <input type="submit" name="cancel" value="Cancel" />
    </form>
</body>

</html>