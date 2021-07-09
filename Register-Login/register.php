<html>
    <link rel="stylesheet" href="app.css">
    <h2>Demo Register-Login</h2><br><br><br><br>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#" method="POST">
                <h1>Create Account</h1><br><br><br>
                <input type="text"  name = "SignUpName" placeholder="Name" autocomplete = "off" />
                <input type="email" name = "SignUpEmail" placeholder="Email" autocomplete = "off"/>
                <input type="password" name = "SignUpPassword" placeholder="Password" autocomplete = "off"/>
                <input type="password" name = "SignUpPassword2" placeholder="Password" autocomplete = "off"/>
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="#" method="POST">
                <h1>Sign in</h1><br><br>
                <input type="email" placeholder="Email" name = "Login-Email" autocomplete = "off" />
                <input type="password" placeholder="Password" name = "Login-Password" autocomplete = "off"/><br>
                <button>Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="signin" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="signup" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</html>
<?php
    // Sign Up Started
    $SignUpName = $_POST['SignUpName'];
    $SignUpEmail = $_POST['SignUpEmail'];
    $SignUpPassword = $_POST['SignUpPassword'];
    $SignUpPassword2 = $_POST['SignUpPassword2'];
    if (isset($_POST['SignUpName'])) {
        if (CheckName($SignUpName) and CheckMail($SignUpEmail)){
            if (CheckPassword($SignUpPassword) == true){
                if (CheckPassword2($SignUpPassword,$SignUpPassword2)) {
                    Register($SignUpName,$SignUpEmail,$SignUpPassword);
                }else {
                    warn("Passwords not match.");
                }
            }else {
                warn("Enter a harder password.");
            }
        }else {
            warn("Mail or username is used by another user");
        }
    }


    function CheckName($SignUpName){
        $link = mysqli_connect("localhost", "root", "12345678", "mixas");
        $CheckName = "SELECT * FROM users WHERE username='$SignUpName';";
        $result = mysqli_query($link, $CheckName);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return false;
            }
        }else {
            return true;
        }
        mysqli_close($link);
    }
    
    function CheckMail($SignUpEmail){
        $link = mysqli_connect("localhost", "root", "12345678", "mixas");
        $CheckName = "SELECT * FROM users WHERE email='$SignUpEmail';";
        $result = mysqli_query($link, $CheckName);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return false;
            }
        }else {
            return true;
        }
        mysqli_close($link);
    }

    function CheckPassword($SignUpPassword){
        $CheckPW = "/\S*((?=\S{8,})(?=\S*[A-Z]))\S*/";
        if(preg_match($CheckPW,$SignUpPassword)){  
            return true;
        }else {
            return false;
        }
    }

    function CheckPassword2($SignUpPassword,$SignUpPassword2){
        if ($SignUpPassword == $SignUpPassword2) {
            return true;
        }else {
            return false;
        }
    }

    function Register($SignUpName,$SignUpEmail,$SignUpPassword){
        $sql = mysqli_connect("localhost", "root", "12345678", "mixas");
        $image = "https://media.discordapp.net/attachments/825439550200873000/862999621960466452/FsBQ7awALZX-xGGthgYseo4IrDsQsO59urYTiwb7kG0u5usaUKppI9jZP_GL2C3EgucFilfj7qQT7UpASaS-nACAi_cAio2ikrwe.png";
        $RegisterInto = "INSERT INTO users (username, email, userpassword, userprofile) VALUES ('$SignUpName', '$SignUpEmail','$SignUpPassword', '$image')";
        success("Registration Successful.");
        mysqli_query($sql, $RegisterInto);
        mysqli_close($sql);
    }

    // Sign Up Finished

    // Sign In Started

    $loginmail = $_POST['Login-Email'];
    $password = $_POST['Login-Password'];
    if (isset($_POST['Login-Email'])) {
        $sql = mysqli_connect("localhost", "root", "12345678", "mixas");
        $checkPasswordAndUsername = "SELECT * FROM users WHERE email = '$loginmail' and userpassword = '$password'";
        $result = mysqli_query($sql, $checkPasswordAndUsername);
        $count = mysqli_num_rows($result);
        if($count == 1) {
            success('Login successful');
        }else {
            warn('Password does not match');
        }
    }
    // Sign In Finished

    function warn($message) {  
        echo "<br><h1 style='color:rgb(218, 52, 52);'>$message</h1>";
    }

    function success($message) {  
        echo "<br><h1 style='color:green;'>$message</h1>";
    }


?>