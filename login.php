<?php  
session_start();

if(isset($_POST["email"]) && isset($_POST["password"])){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "final_project";

    $conn = new mysqli($servername, $username, $password, $dbName);
    if($conn->connect_error){
        // An error occurred during the database connection
        echo "Could not connect to the database!";
        header("Location: auth.php?error=db");
        die();
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    $findUser = $conn->prepare("SELECT * FROM `users` WHERE `email` = ? AND `password` = ?");
    $findUser->bind_param("ss", $email, $password);
    $findUser->execute();
    $userResult = $findUser->get_result();

    if($userResult->num_rows == 0){
        // Wrong credentials
        header("Location: auth.php?error=credentials");
        die();
    }

    $user = $userResult->fetch_assoc();

    $_SESSION["userId"] = $user["id"];
    $_SESSION["firstName"] = $user["first_name"];

    header("Location: todo.php");
}
?>
