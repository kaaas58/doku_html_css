<?php
    require("connection.php");

    if (isset($_POST["submit"])) {
        var_dump($_POST); // var_dump() gibt alle Variablen und ihre Werte aus

        // Récupération des valeurs du formulaire
        $name = $_POST["name"];     // name 
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // check if user already exists in database and create  new user    
        $statement = $con->prepare("SELECT * FROM users WHERE username=:username OR email=:email");
        $statement->bindParam(":username", $name); // bindParam() verbindet die Variablen mit den Werten
        $statement->bindParam(":email", $email);
        $statement->execute(); 

        $user = $statement->fetch(PDO::FETCH_ASSOC);  // fetch() gibt alle Werte zurück

        if($user && password_verify($password, $user["password"])){ 
            // Passwort korrekt eingegeben und Session starten
            session_start();
            $_SESSION['user_id  = :user_id '];
            $_SESSION['username'] = $user["username"];
            header("Location: homepage.php"); // return result to a new page with the new username  and password 
        } else {
            // username oder email sind nicht korrekt eingegeben
            $error_message = "Benutzername oder Passwort falsch";
        }
    }
?>


<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seite zur Anmeldungsseite</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="index.php" method="post">
        <div class="container">
            <h1 class="login-vertical">LOGIN</h1>

            <div class="login">
                <div class="login-tilted"></div>
                <div class="user">
                    <i class="ri-user-fill"></i>
                </div>
                <h1 class="login-title">ANMELDUNG</h1>
                <!--php require-->
                <?php if (isset($error_message)) : ?>
                <p class="error-message ">
                    <?php echo $error_message;?>
                </p>
                <?php endif; ?>
                <input type="text" name="name" placeholder="Benutzername" class="username" required>
                <input type="password" name="password" placeholder="Password" class="password" required>

                <div class="login-btn">
                    <button type="submit" name="submit">
                        <i class="ri-play-line"></i>
                    </button>
                </div>
                <a href="registrierung.php" class="forgot">Passwort vergessen</a>
            </div>
        </div>
    </form>
</body>

</html>