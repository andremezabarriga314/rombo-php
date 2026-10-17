
<?php
session_start();

require_once __DIR__ . '/../controller/AuthController.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $clave = $_POST['clave'] ?? '';

    if ($correo === '' || $clave === '') {
        $mensaje = 'Complete todos los campos';
    } else {
        $auth = new AuthController();

        if ($auth->login($correo, $clave)) {
            header('Location: home.php');
            exit;
        }

        $mensaje = 'Correo o clave incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">

    <meta
        name="description"
        content="Sistema de cálculo del área y perímetro de la rombo"
    >

    <meta
        name="keywords"
        content="circunferencia, radio, área, perímetro, sistema"
    >

    <meta name="author" content="Andre Meza">

    <link rel="icon" href="../imagenes/image.png">
    <link rel="stylesheet" href="../assetes/css/style.css">

    <title>Inicio de sesión | Rombo</title>
</head>

<body>

<header>
</header>

<main>
    <div class="caja">
        <form action="" method="post" id="frmLogin">
            <img
                src="../imagenes/logo.ico"
                alt="Logo del sistema de matemáticas"
            >

            <input
                type="email"
                name="correo"
                id="correo"
                placeholder="Correo"
                autocomplete="username"
                required
                value="<?php echo htmlspecialchars(
                    $_POST['correo'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>"
            >

            <input
                type="password"
                name="clave"
                id="clave"
                placeholder="Clave"
                autocomplete="current-password"
                required
            >

            <button type="submit" id="btnIngresar">
                Ingresar
            </button>
        </form>

        <?php if ($mensaje !== '') : ?>
            <p class="mensaje" role="alert">
                <?php echo htmlspecialchars(
                    $mensaje,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>
            </p>
        <?php endif; ?>
    </div>
</main>

<footer>
</footer>

<script src="../assetes/js/app.js"></script>

</body>
</html>
