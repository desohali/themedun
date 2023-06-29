<?php
// if (!$_SERVER['HTTPS']) {
//     header("Location: " . preg_replace('/http:/', 'https:', $_SERVER['HTTP_REFERER']));
// }

if (isset($_GET['view'])) {
    unset($login);
    $views = explode("/", $_GET['view']);
    if (is_file($views[0] . '.php')) {
        include $views[0] . '.php';
    } else {
        include '404.php';
    }
} else {
    session_start();

    if (isset($_SESSION['id'])) {
        header("Location: " . $_ENV['APP_URL'] . "home");
    } else if (isset($_SESSION['idpro'])) {
        header("Location: " . $_ENV['APP_URL'] . "perfilpro/" . $_SESSION['idpro']);
    } else if (isset($_SESSION['idAdmin'])) {
        header("Location: " . $_ENV['APP_URL'] . "activos");
    } else {
        session_destroy();
        $login = "login";
        include 'login.php';
    }
}


$seguridad = empty($seguridad) ? new Seguridad($conexion, "") : $seguridad;

// VERIFCAMOS QUE LA RUTA SEA VALIDA
$allRutas = array_merge(
    $seguridad->rutasPublicas,
    $seguridad->rutasPaciente,
    $seguridad->rutasMedico,
    $seguridad->rutasAdministrador,
    $seguridad->rutasSiempreAccesibles,
);

$path = explode("/", parse_url($_SERVER['REQUEST_URI'])['path']);

$isRouteValid = false;
foreach ($allRutas as $key => $value) {
    if (in_array($value, $path) || isset($login)) {
        $isRouteValid = true;
    }
}

// SI LA RUTA ES INVALIDA O NO ESTA DEFINIDA MOSTRAMOS LA PLANTILLAS 404.PHP
if (!$isRouteValid) {
    echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "404');</script>";
    exit();
}
?>
<script>
    // REDIRIGIR AL PROTOCOLO SEGURO
    /* if (window.location.protocol === 'http:') {
        if (window.location.host !== "localhost") {
            window.location.replace(window.location.href.replace(/http:/, 'https:'));

        }
    } */

    const enviarCorreo = async (json) => {
        const formData = new FormData();
        formData.append("to", json.correo);
        formData.append("subject", json.titulo);
        formData.append("html", json.mensaje);

        const response = await fetch("https://warm-oasis-35751-a8b52ba3e521.herokuapp.com/sendMail", {
            method: "post",
            body: formData,
        });

        return await response.json();
    }
</script>