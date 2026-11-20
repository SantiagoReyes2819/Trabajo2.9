
<?php

// Obtener las primeras tres letras del nombre
function obtenerIniciales($nombre) {
    $nombre = trim($nombre);
    $nombre = str_replace(" ", "", $nombre);

    return strtoupper(substr($nombre, 0, 3));
}

// Obtener los ultimos dos digitos del año
function obtenerAnio($fecha) {
    return substr($fecha, 2, 2);
}

// Obtener el mes y el dia
function obtenerMesDia($fecha) {
    $mes = substr($fecha, 5, 2);
    $dia = substr($fecha, 8, 2);

    return $mes . $dia;
}

// Formar la clave completa
function generarClave($nombre, $fecha) {
    $iniciales = obtenerIniciales($nombre);
    $anio = obtenerAnio($fecha);
    $mesDia = obtenerMesDia($fecha);

    return $iniciales . $anio . $mesDia;
}

$resultado = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $fecha = trim($_POST["fecha"]);

    if ($nombre == "" || $fecha == "") {
        $error = "Completa todos los campos.";
    } elseif (strlen($nombre) < 3) {
        $error = "El nombre debe tener al menos tres caracteres.";
    } else {
        $partes = explode("-", $fecha);

        if (count($partes) != 3 || !checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
            $error = "Escribe una fecha valida.";
        } else {
            $resultado = generarClave($nombre, $fecha);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de claves</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="contenedor">

        <a class="regresar" href="index.php">Regresar al menu</a>

        <h1>Generador de claves</h1>
        <p>Ingresa tu nombre completo y fecha de nacimiento.</p>

        <form method="POST">

            <label>Nombre completo:</label>
            <input type="text" name="nombre" placeholder="Ej. Carlos Alberto Perez" required>

            <label>Fecha de nacimiento:</label>
            <input type="date" name="fecha" required>

            <button type="submit">Generar clave</button>

        </form>

        <?php if ($error != "") { ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <?php if ($resultado != "") { ?>
            <div class="resultado">
                <h3>Clave generada</h3>
                <h2><?php echo htmlspecialchars($resultado); ?></h2>
            </div>
        <?php } ?>

    </div>

</body>
</html>
