<?php
    

    if(isset($_POST["firstName"]) &&
    isset($_POST["lastName"])&& 
    isset($_POST["email"])&&
    isset($_POST["password"])&&
    isset($_POST["phoneNumber"])){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbName = "final_project";

        $conn = new mysqli($servername, $username, $password, $dbName);
        if($conn->connect_error){
            //ka ndodhur nje error gjate lidhjes me databaze
            echo "Could not connect ot the database!";
            header("Location:auth.php");
            die();
        }
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $phoneNumber = $_POST["phoneNumber"];
        $email = $_POST["email"];
        $userPassword = $_POST["password"];
         //check a ka naj user me email te njejte ose username te njejte
         $checkDuplicate = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
         $checkDuplicate->bind_param("s", $email);
 
         $checkDuplicate->execute(); 
         $duplicateResult = $checkDuplicate->get_result();
 
         if($duplicateResult->num_rows > 0){
             header("Location: auth.php");
             die();
         }
        


        $stmt = $conn->prepare("INSERT INTO `users` (`first_name`, `last_name`,`phone_number`, `email`, `password`) VALUES (?, ?, ?,?,?)");
        $stmt->bind_param("sssss", $firstName, $lastName,$phoneNumber, $email, $userPassword);

        $stmt->execute();

        $stmt->close();
        $conn->close();
       
    
        header("Location:auth.php");
        }
?>