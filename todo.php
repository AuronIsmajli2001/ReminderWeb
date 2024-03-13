<?php
    //protect the profile
    session_start();
    if(!isset($_SESSION["userId"])){
        header("Location:auth.php");
        die();
    }

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REMINDER</title>
    <link rel="stylesheet" href="todo.css">
</head>
<body>
    <div class="nav">
        <div></div>
        <form method="post" action="logout.php">
            <input type="submit" id="signOut" value="SignOut">
        </form>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="menu">
                <h3>To Do</h3>
            </div>
            <div class="butoni">
                <button onclick="formPopUp()" id="add">ADD</button>
            </div>
            <?php
                $userId = $_SESSION["userId"];
                $getAllToDo = $conn->prepare("SELECT * FROM `reminders` WHERE `done` = 0 AND `user_id` = ? ORDER BY `deadline` ASC");
                
                if ($getAllToDo === false) {
                    die('Error in SQL query: ' . $conn->error);
                }
                
                $getAllToDo->bind_param("i", $userId);
                
                if (!$getAllToDo->execute()) {
                    die('Error executing statement: ' . $getAllToDo->error);
                }
                
                $allToDo = $getAllToDo->get_result();
                $currentDateTime = new DateTime(); // Get current date and time

                while($row = $allToDo->fetch_assoc()) {
                    $reminderTitle = $row["title"];
                    $time = new DateTime($row["deadline"]);
                    $reminderDate = $time->format('j.n.Y');
                    $reminderTime = $time->format('H:i');
                    $reminderDescription = $row["description"];
                    $reminderId = $row["id"];    

                    // Check if the deadline has passed
                    if ($currentDateTime > $time) {
                        echo '<div class="card" style="border: 2px solid red;">'; // Apply red border
                    } else {
                        echo '<div class="card">';
                    }

                    echo '<div class="title">' .
                            '<p>' . $reminderTitle . '</p>' .
                            '</div>' .
                        '<div class="time">' .
                            '<div><p>' . $reminderDate . '</p></div>' .
                            '<div><p>' . $reminderTime . '</p></div>' .
                        '</div>' .
                        '<div style="padding: 1em; padding-left: 0em;">' .
                            '<button onclick="showDetails(\'' . $reminderTitle . '\', \'' . $reminderDescription . '\')" class="details" style="background-color: gray;
                            border: 1px black solid;
                            font: black;
                            border-radius: 10px;
                            cursor: pointer;
                            padding: 10px 15px 10px 15px;
                            font-weight: bold;
                            ">Show Details</button>' .
                        '</div>' .
                        '<div class="buttons">' .
                            '<form method="post" action="delete-reminder.php"> <input type="hidden" name="id" value="' . $reminderId . '"> <button onclick="deleteCard()" class="button1" type="submit">Delete</button></form>' .
                            '<form method="post" action="done-reminder.php"> <input type="hidden" name="id" value="' . $reminderId . '"> <button onclick="doneCard()" class="button2" type="submit">Done</button></form>' .
                        '</div>' .
                    '</div>';
                }
            ?>   
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="menu">
                <h3>Done</h3>
            </div>
            <?php
                $userId = $_SESSION["userId"];
                $getAllToDo = $conn->prepare("SELECT * FROM `reminders` WHERE `done` = 1 AND `user_id` = ? ORDER BY `deadline` ASC");
                $getAllToDo->bind_param("i", $userId);
                $getAllToDo->execute();
                $allToDo = $getAllToDo->get_result();

                while($row = $allToDo->fetch_assoc()) {
                    $reminderTitle = $row["title"];
                    $time = new DateTime($row["deadline"]);
                    $reminderDate = $time->format('j.n.Y');
                    $reminderTime = $time->format('H:i');
                    $reminderDescription = $row["description"];
                    $reminderId = $row["id"];    

                    echo '<div class="card">' . 
                            '<div class="title">' .
                                '<p>' . $reminderTitle . '</p>' .
                                '</div>' .
                            '<div class="time">' .
                                '<div><p>' . $reminderDate . '</p></div>' .
                                '<div><p>' . $reminderTime . '</p></div>' .
                            '</div>' .
                            '<div style="padding: 1em; padding-left: 0em;">' .
                                '<button onclick="showDetails(\'' . $reminderTitle . '\', \'' . $reminderDescription . '\')" class="details" style="background-color: gray;
                                border: 1px black solid;
                                font: black;
                                border-radius: 10px;
                                cursor: pointer;
                                padding: 10px 15px 10px 15px;
                                font-weight: bold;
                                ">Show Details</button>' .
                            '</div>' .
                            '<div class="buttons">' .
                                '<form method="post" action="delete-reminder.php"> <input type="hidden" name="id" value="' . $reminderId . '"> <button onclick="deleteCard()" class="button1" type="submit">Delete</button></form>' .
                            '</div>' .
                        '</div>';
                }
            ?>   
        </div>
    </div>
    <div id="showDetail" class="showDetails">
        <div class="detailsHeader" id="detailsHeader">
            <div style="display: flex; justify-content: flex-end;">
                <button onclick="hideDetails()" id="x" class="x">X</button>
            </div>
            <h1>Title</h1>
            <h3 id="detailsT">Go to School</h3>
            <h1>Description</h1>
            <p id="detailsP">Lorem ipsum dolor sit amet?</p>
        </div>
    </div>
    <div id="popup" style="display: none;" class="popup">
        <form method="post" action="create-reminder.php" class="box">
            <p>CREATE</p> 
            <input name="title" type="text" placeholder="Title" required>
            <input name="date" type="datetime-local" required min="<?php echo date('Y-m-d\TH:i'); ?>">
            <textarea name="details" placeholder="Details" required></textarea>
            <input class="submit" type="submit" name="create-todo">
        </form>
    </div>  
    
    <script>
        function formPopUp(){
            let PopUp = document.getElementById('popup').style.display = 'flex';
        }
        function RemovePopUp(){
            let remove = document.getElementById('popup').style.display = 'none';
        }
        function hideDetails(){
            document.getElementById('showDetail').style.display = 'none';
        }

        function showDetails(title, desc) {
            document.getElementById('detailsP').innerHTML = desc;
            document.getElementById('detailsT').innerHTML = title;
            document.getElementById('showDetail').style.display = 'flex';
            document.getElementById('detailsHeader').style.display = 'flex';
            document.getElementById('detailsHeader').style.flexDirection = 'column';    
            document.getElementById('detailsHeader').style.textAlign = 'center';
            document.getElementById('detailsHeader').style.padding = '70px 70px 70px 70px';
        }
    </script>
</body>
</html>
