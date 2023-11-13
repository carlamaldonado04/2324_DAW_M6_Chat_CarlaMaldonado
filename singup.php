<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            background-size: cover; /* Ajusta el tamaño de la imagen al botón */
            background-position: center; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif; 
            margin: 0;
            flex-flow: column;

        }

        h1{
            color: white;
            font-size: 50px;
            z-index: 10;
            margin-top: 0px;


        }

        /* Style for form container */
        .form-container {
            border-radius: 20px;
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            z-index: 10;

        }

        /* Style for form labels */
        label {
            display: block;
            margin-bottom: 5px;
        }

        /* Style for form input fields */
        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Style for error messages */
        .error-message {
            color: red;
            font-size: 14px;
        }

        /* Style for the submit button */
        input[type="submit"] {
            background-color: #fe57b1;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #CB458D;
        }
    </style>
</head>
<body>
    <h1>Welcome again!</h1><br>
    <video src="img/Grabación de pantalla 2023-11-13 a las 18.14.58.mov" autoplay muted loop style="position: absolute;"></video>

    <div class="form-container">
        <form action="comprobacion_user.php" method="post">
            <!-- Email -->
            <?php if (isset($_GET['correoVacio'])) {echo "<div class='error-message'>Email vacío. Has de introducir un email válido.</div>"; } ?>

            <?php if (isset($_GET['correoMal'])) {echo "<div class='error-message'>El email no está registrado.</div>"; } ?>

            <?php if (isset($_GET['correoRepetido'])) {echo "<div class='error-message'>El correo ya existe.</div>"; } ?>

            <label for="correo">Email</label>
            <input type="text" name="correo" id="correo" value="<?php if(isset($_GET["correo"])) {echo $_GET["correo"];} ?>">

            <!-- Contraseña -->
            <?php if (isset($_GET['contrasenaVacio'])) {echo "<div class='error-message'>Contraseña vacía. Has de introducir una contraseña válida.</div>"; } ?>

            <?php if (isset($_GET['contrasenaMal'])) {echo "<div class='error-message'>El formato de la contraseña es incorrecto.</div>"; } ?>

            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" value="<?php if(isset($_GET["contrasena"])) {echo $_GET["contrasena"];} ?>">

            <br/><br>

            <input type="submit" name="enviar" value="Enviar" style="width: 100%;">

            <p style="text-align: center;">Todavia no tienes una cuenta? Create una <a href=" ./login.php" style="color:#fe76c1">aqui</a></p> </form>
    </div>
</body>
</html>
