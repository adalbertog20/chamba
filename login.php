<?php
session_start();
include('database.php');
if (isset($_SESSION['user_id'])) {
    header('Location: /chamba');
}
if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
    $correo = $_POST['correo'] ?? null;
    $contrasena = $_POST['contrasena'] ?? null;

    $correo = stripcslashes($correo);
    $contrasena = stripcslashes($contrasena);
    $correo = mysqli_real_escape_string($con, $correo);
    $contrasena = mysqli_real_escape_string($con, $contrasena);

    $sql = "SELECT contrasena FROM cliente WHERE correo = '$correo'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION['correo'] = $correo;
        echo "<h1><center> Login successful </center></h1>";
        header("Location: /chamba");
    } else {
        echo "<h1> Login failed. Invalid username or password.</h1>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>
    <?php require 'partials/navbar.php' ?>

    <?php if (!empty($message)) : ?>
        <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Login</h1>
    <span>or <a href="signup.php">SignUp</a></span>

    <form class="form-control" action="login.php" method="post">
        <div class="d-flex justify-content-center m-3">
            <div class="border rounded-4 p-3 w-25 d-flex flex-column align-items-center">
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contrasena</label>
                    <input type="password" arial-labelledby="passwordHelpBlock" class="form-control" id="correo" name="contrasena" required>
                </div>
                <button class="btn btn-success" type="submit">Iniciar sesion</button>
            </div>
        </div>
    </form>
</body>

</html>