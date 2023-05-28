<?php
error_reporting(E_ERROR | E_PARSE);
include('database.php');
$nomEmpresa = $_POST['nomEmpresa'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$apellidos = $_POST['apellidos'] ?? null;
$correo = $_POST['correo'] ?? null;
$contrasena = $_POST['contrasena'] ?? null;
$pais = $_POST['pais'] ?? null;
$estado = $_POST['estado'] ?? null;
$ciudad = $_POST['ciudad'] ?? null;
$cp = $_POST['cp'] ?? null;
$direccion = $_POST['direccion'] ?? null;
$is_trabajador = $_POST['is_trabajador'] ?? null;
$tabla = "cliente";
$correo_utilizado = 0;

$targetDir = "uploads/"; // Directory where you want to store the uploaded files
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
if (isset($_POST['is_trabajador'])) {
    $sql = "SELECT * FROM trabajador WHERE correo = '$correo'";
    $tabla = "trabajador";
} else {
    $sql = "SELECT * FROM cliente WHERE correo = '$correo'";
}

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($correo == isset($row['correo'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Hey Tilin!</strong> el correo que quieres utilizar ya esta tomado, intenta con otro.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
}
if (isset($_POST['submit'])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // If everything is ok, try to upload the file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO images (file_name, uploaded_on) VALUES ('$targetFile', NOW())";
            $result = mysqli_query($con, $sql);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    if ($tabla === "cliente") {
        $sql = "INSERT INTO `cliente` 
    ( nomEmpresa, nombre, apellidos, correo, contrasena, pais, estado, ciudad, codigoPostal, direccion)
    VALUES
    ('$nomEmpresa', '$nombre', '$apellidos', '$correo', '$contrasena', '$pais' ,'$estado', '$ciudad', '$cp', '$direccion')";
        $result = mysqli_query($con, $sql);
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert"> Su cuenta como cliente se creo satisfactoriamente <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
        header("Location: /chamba");
    } else if ($tabla === "trabajador") {
        $sql = "INSERT INTO `trabajador` 
    ( nombre, apellidos, correo, contrasena, pais, estado, ciudad, codigoPostal, direccion)
    VALUES
    ('$nombre', '$apellidos', '$correo', '$contrasena', '$pais' ,'$estado', '$ciudad', '$cp', '$direccion')";
        $result = mysqli_query($con, $sql);
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert"> Su cuenta como trabajador se creo satisfactoriamente <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
        header("Location: /chamba");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
</head>

<body>
    <?php include('partials/navbar.php'); ?>

    <form class="form-control" action="signup.php" method="post" enctype="multipart/form-data">
        <div class="d-flex justify-content-center m-3">
            <div class="border rounded-4 p-3 w-50 d-flex flex-column align-items-center">
                <div class="mb-3">
                    <label class="form-label">Nombre de la empresa</label>
                    <input type="text" class="form-control" id="nomEmpresa" name="nomEmpresa">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contrasena</label>
                    <input type="password" arial-labelledby="passwordHelpBlock" class="form-control" id="correo" name="contrasena" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pais</label>
                    <input class="form-control" list="datalistOptions" id="DataList" placeholder="Escriba su pais..." name="pais">
                    <datalist id="datalistOptions">
                        <option value="México">
                        <option value="Canada">
                        <option value="Estados Unidos">
                        <option value="Brasil">
                        <option value="Otro">
                    </datalist>
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Codigo Postal</label>
                    <input type="text" class="form-control" id="cp" name="cp" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Direccion</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>

                <label for="formFile" class="form-label">Sube tu imagen de perfil</label>
                <div class="d-flex">
                    <input name="fileToUpload" class="form-control" type="file" id="formFile">
                    <input class="form-check-button" type="submit" name="submit" value="Upload">
                </div>

                <div class="mb-2">
                    <div class="form-check mb-2">
                        <div>
                            <input class="form-check-input" type="checkbox" value="true" name="is_trabajador">
                            <label class="form-check-label" for="flexCheckDefault">Crear Cuenta Como Trabajador?</label>
                        </div>
                    </div>
                </div>
                <button name="submit" class="btn btn-success" type="submit">registrarse</button>
            </div>
        </div>
    </form>
</body>

</html>