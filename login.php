<!DOCTYPE html>
<html>

<head>
    <title>#BENJAMIN FERNANDEZ#</title>
</head>

<?php 
    require "pdo.php";

    session_start();

    $salt =  'XyZzy12*_';//add


    if (isset($_POST['email']) && isset($_POST['pass'])) {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :pass";

        $statement = $pdo->prepare($sql);
        $check = hash('md5', $salt.$_POST['pass']);//add
        $statement->execute(array(
            ":email" => $_POST['email'],
            ":pass" => $check //add
        ));

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row == false) {
            $_SESSION['error'] = "Incorrect Password";
            header("Location: login.php");
            return;
        }

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        header("Location: index.php");
        return;
    }

?>

<body>
    <h1>Please Log In</h1>
    <?php 
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
    ?>
    <form method="post">

        <p>Email:
            <input type="text" name="email" id="email" />
        </p>

        <p>Password:
            <input type="text" name="pass" id="pass" />
        </p>

        <button type="submit" onclick="return sub();">Log In</button>

    </form>

    <script>
    function sub() {
        try {
            console.log("HERE");
            let email = document.getElementById("email").value;
            let password = document.getElementById("pass").value;

            if (email == null || password == null || email == "" || password == "") {
                alert("Both fields are necessary");
                return false;
            }
            if (email.indexOf("@") == -1) {
                alert("Enter valid email");
                return false;
            }
            console.log("HERE");
            return true;
        } catch (e) {
            alert(e);
            return false;
        }
        return false;
    }
    </script>
</body>

</html>