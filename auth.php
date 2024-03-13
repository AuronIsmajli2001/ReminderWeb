
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REMINDER</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body style="flex-direction : column;gap:10px;">
    <?php
        if (isset($_GET["error"]) && $_GET["error"] == "credentials") {
            echo '<div id="hana" style="border-radius:50px;padding:10px;background-color: rgb(186, 186, 186);border:#750000 2px solid;color: #750000; text-align: center; margin-top: 10px;">Incorrect email or password. Please try again!</div>';
        } 
        elseif (isset($_GET["error"]) && $_GET["error"] == "db") {
            echo '<div style="color: red; text-align: center; margin-top: 10px;">An error occurred. Please try again later!</div>';
        }
    ?>
    <div class="logInSignIn">
        <div class="buttonsMenu">
            <button id="LogIn" onclick="LogIn()" class="buttons">LogIn</button>
            <button id="SignUp" onclick="SignUp()" class="buttons">SignUp</button>
        </div>
        <form method="post" action="login.php" id="logIN" class="logIn"> 
            <h3>Log In</h3>
            <div style="display: flex; align-items: center; flex-direction: row; justify-content: space-between;">
            <label>Email :</label>
            <input name="email" placeholder="Email" type="email">
        </div>
            <div style="display: flex; align-items: center; flex-direction: row; justify-content: space-between;">
            <label>Password :</label>
            <input name="password" placeholder="Password" type="password">
        </div>
            <div style="display: flex; align-items: center; justify-content: space-around;">
            <a href="">Forgot Password?</a><input type="checkbox"><label> Remember Me</label>
        </div>
            <input type="submit" class="buttonLogCreate" value="Log In">
        </form>
        <form method="post" action="signup.php" id="signUP" class="signUp" onsubmit="return validateForm()">
            <h3>Create a new account!</h3>
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <label>FirstName :</label>
                <input name="firstName" id="firstName" placeholder="FirstName" pattern="[A-Za-z]+" title="Please enter only letters" required type="text" required>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between ;">
                <label>LastName :</label>
                <input name="lastName" id="lastName" placeholder="LastName" pattern="[A-Za-z]+" title="Please enter only letters" required type="text" required>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <label>Email :</label>
                <input name="email" placeholder="Email" type="email" required>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <label>Password :</label>
                <input name="password" placeholder="Password" type="password" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$" title="Password must contain at least 1 uppercase letter, 1 number, 1 special character, and be at least 8 characters long" required>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between ;">
                <label>Phone Number :</label>
                <input name="phoneNumber" placeholder="PhoneNumber" id="phnum" type="number" required>
            </div>
            <input type="submit" class="buttonLogCreate" value= "Create">
        </form>
    </div>
    <script>
        function LogIn(){
            document.getElementById('logIN').style.display = 'flex';
            document.getElementById('signUP').style.display = 'none';
        }
        function SignUp(){
            document.getElementById('logIN').style.display = 'none';
            document.getElementById('signUP').style.display = 'flex';
            document.getElementById('hana').style.display = 'none';
        }
        function validateForm() {
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var password = document.getElementById('password').value;

            if (!/(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/.test(password) || password.length < 8) {
                alert('Password must contain at least 1 uppercase letter, 1 number, 1 special character, and be at least 8 characters long');
                return false;
            }

            if (!/^[a-zA-Z]+$/.test(firstName)) {
                alert('Please enter only letters for the First Name');
                return false;
            }

            if (!/^[a-zA-Z]+$/.test(lastName)) {
                alert('Please enter only letters for the Last Name');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>