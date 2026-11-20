
<?php

// Quitar espacios del nombre
function limpiarNombre($nombre) {
    $nombre = trim($nombre);
    $nombre = str_replace(" ", "", $nombre);

    return $nombre;
}

// Convertir el nombre a minusculas
function convertirMinusculas($texto) {
    return strtolower($texto);
}

// Obtener las primeras dos letras de la institucion
function obtenerInstitucion($institucion) {
    $institucion = trim($institucion);

    return strtolower(substr($institucion, 0, 2));
}

// Obtener los ultimos dos digitos del año
function obtenerAnio($anio) {
    return substr($anio, -2);
}

// Crear el nombre de usuario
function generarUsuario($nombre, $institucion, $anio) {
    $nombre = limpiarNombre($nombre);
    $nombre = convertirMinusculas($nombre);

    $institucion = obtenerInstitucion($institucion);
    $anio = obtenerAnio($anio);

    return $nombre . $institucion . $anio;
}

$resultado = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $institucion = trim($_POST["institucion"]);
    $anio = trim($_POST["anio"]);

    if ($nombre == "" || $institucion == "" || $anio == "") {
        $error = "Completa todos los campos.";
    } elseif (strlen($institucion) < 2) {
        $error = "La institucion debe tener al menos dos letras.";
    } elseif (!preg_match("/^[0-9]{4}$/", $anio)) {
        $error = "Escribe un año de cuatro digitos.";
    } else {
        $resultado = generarUsuario($nombre, $institucion, $anio);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de usuarios</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="contenedor">

        <a class="regresar" href="index.php">Regresar al menu</a>

        <h1>Generador de usuarios</h1>
        <p>Ingresa los datos para crear tu nombre de usuario.</p>

        <form method="POST">

            <label>Nombre completo:</label>
            <input type="text" name="nombre" placeholder="Ej. Maria Fernanda Lopez" required>

            <label>Institucion educativa:</label>
            <input type="text" name="institucion" placeholder="Ej. CBTIS" required>

            <label>Año de ingreso:</label>
            <input type="number" name="anio" placeholder="Ej. 2026" min="1000" max="9999" required>

            <button type="submit">Generar usuario</button>

        </form>

        <?php if ($error != "") { ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <?php if ($resultado != "") { ?>
            <div class="resultado">
                <h3>Usuario generado</h3>
                <h2><?php echo htmlspecialchars($resultado); ?></h2>
            </div>
        <?php } ?>

    </div>

</body>
</html>
