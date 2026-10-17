
<?php
session_start();

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/RomboController.php';

AuthController::verificarSesion();

$romboController = new RomboController();

$mensaje = $_GET['mensaje'] ?? '';
$mensajeFormulario = $romboController->procesarFormulario();

if ($mensajeFormulario !== '') {
    $mensaje = $mensajeFormulario;
}

$mensajes = [
    'guardado' => 'Rombo registrado correctamente.',
    'actualizado' => 'Rombo actualizado correctamente.',
    'eliminado' => 'Rombo eliminado correctamente.'
];

if (isset($mensajes[$mensaje])) {
    $mensaje = $mensajes[$mensaje];
}

$buscar = trim($_GET['buscar'] ?? '');
$registroEditar = null;

if (isset($_GET['editar'])) {
    $registroEditar = $romboController->obtenerParaEditar(
        (int) $_GET['editar']
    );
}

$registros = $romboController->listar($buscar);

$idActual = $registroEditar['id_rombo'] ?? '';
$detalleActual = $registroEditar['detalle'] ?? '';
$diagonalMayorActual = $registroEditar['diagonal_mayor'] ?? '';
$diagonalMenorActual = $registroEditar['diagonal_menor'] ?? '';
$ladoActual = $registroEditar['lado'] ?? '';
$areaActual = $registroEditar['area'] ?? '';
$perimetroActual = $registroEditar['perimetro'] ?? '';

function escapar(mixed $valor): string
{
    return htmlspecialchars(
        (string) ($valor ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Sistema de cálculo del área y perímetro del rombo">
    <meta name="keywords" content="rombo, diagonal mayor, diagonal menor, área, perímetro">
    <meta name="author" content="Andre Meza">

    <link rel="icon" href="../imagenes/icono.png">
    <link rel="stylesheet" href="../assetes/css/style_home.css">

    <title>Rombo - Principal</title>
</head>

<body>

<header class="headeerHome">
    <div class="lineaSup">
        <div class="logo-links">
            <div class="logo">
                <img src="../imagenes/logo.png" alt="Logo">
                <h1>Matemáticas</h1>
            </div>

            <a href="#informacion">Quiénes somos</a>
        </div>

        <div class="buscarHeader">
            <form class="form1" action="home.php" method="get">
                <img src="../imagenes/logo.png" alt="Buscar">

                <button type="submit">Buscar</button>

                <input
                    type="text"
                    name="buscar"
                    placeholder="BUSCAR"
                    value="<?= escapar($buscar) ?>"
                >
            </form>
        </div>
    </div>

    <div class="lineaInf">
        <nav class="menu">
            <li>
                <a href="home.php">Inicio</a>
            </li>

            <li>
                <a href="#informacion">Nuestra historia</a>
            </li>

            <li>
                <a
                    href="logout.php"
                    onclick="return confirm('¿Desea cerrar sesión?');"
                >
                    Cerrar sesión
                </a>
            </li>
        </nav>
    </div>
</header>

<main>
    <div class="datos">
        <div class="titulo">
            <h1>Cálculo del área y perímetro del rombo</h1>

            <p>
                Usuario:
                <?= escapar($_SESSION['usuario'] ?? 'Usuario') ?>
            </p>
        </div>

        <?php if ($mensaje !== '') : ?>
            <p class="mensaje" role="status">
                <?= escapar($mensaje) ?>
            </p>
        <?php endif; ?>

        <form
            action="home.php<?= $buscar !== '' ? '?buscar=' . urlencode($buscar) : '' ?>"
            method="post"
            class="form2"
            id="frmFormulario"
        >
            <input
                type="hidden"
                name="id_rombo"
                value="<?= escapar($idActual) ?>"
            >

            <div class="inputs">
                <label for="txtDiagonalMayor">Diagonal mayor</label>

                <input
                    class="inputHome"
                    type="number"
                    name="txtDiagonalMayor"
                    id="txtDiagonalMayor"
                    placeholder="Ingrese la diagonal mayor"
                    min="0.000001"
                    step="any"
                    required
                    value="<?= escapar($diagonalMayorActual) ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtDiagonalMenor">Diagonal menor</label>

                <input
                    class="inputHome"
                    type="number"
                    name="txtDiagonalMenor"
                    id="txtDiagonalMenor"
                    placeholder="Ingrese la diagonal menor"
                    min="0.000001"
                    step="any"
                    required
                    value="<?= escapar($diagonalMenorActual) ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtDetalle">Detalle</label>

                <input
                    class="inputHome"
                    type="text"
                    name="txtDetalle"
                    id="txtDetalle"
                    placeholder="Ingrese un comentario"
                    maxlength="255"
                    value="<?= escapar($detalleActual) ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtLado">Lado calculado</label>

                <input
                    class="inputHome"
                    type="text"
                    id="txtLado"
                    readonly
                    placeholder="Lado"
                    value="<?= escapar($ladoActual) ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtA">Área</label>

                <input
                    class="inputHome"
                    type="text"
                    id="txtA"
                    readonly
                    placeholder="Área"
                    value="<?= escapar($areaActual) ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtP">Perímetro</label>

                <input
                    class="inputHome"
                    type="text"
                    id="txtP"
                    readonly
                    placeholder="Perímetro"
                    value="<?= escapar($perimetroActual) ?>"
                >
            </div>

            <div class="botones">
                <button type="button" id="btnCalcular">
                    Calcular
                </button>

                <a class="btn-link cancelar" href="home.php">
                    Cancelar
                </a>

                <button type="submit" name="accion" value="guardar">
                    <?= $idActual !== '' ? 'Actualizar' : 'Guardar' ?>
                </button>
            </div>
        </form>
    </div>

    <div class="buscar">
        <form action="home.php" method="get" id="frmBuscar">
            <img src="../imagenes/logo.png" alt="Buscar">

            <button type="submit">Buscar</button>

            <input
                type="text"
                name="buscar"
                id="txtBuscarHistorial"
                placeholder="Buscar por diagonal, área o detalle"
                value="<?= escapar($buscar) ?>"
            >

            <a class="btn-link limpiar" href="home.php">
                Limpiar
            </a>
        </form>
    </div>

    <div class="tabla">
        <h1>Historial de los cálculos del rombo</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Diagonal mayor</th>
                    <th>Diagonal menor</th>
                    <th>Lado</th>
                    <th>Detalle</th>
                    <th>Área</th>
                    <th>Perímetro</th>
                    <th>Fecha y hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($registros) > 0) : ?>

                    <?php foreach ($registros as $fila) : ?>
                        <tr>
                            <td><?= escapar($fila['id_rombo']) ?></td>

                            <td><?= escapar($fila['diagonal_mayor']) ?></td>

                            <td><?= escapar($fila['diagonal_menor']) ?></td>

                            <td><?= escapar($fila['lado']) ?></td>

                            <td><?= escapar($fila['detalle']) ?></td>

                            <td><?= escapar($fila['area']) ?></td>

                            <td><?= escapar($fila['perimetro']) ?></td>

                            <td><?= escapar($fila['fecha_registro'] ?? '') ?></td>

                            <td class="acciones">
                                <a
                                    class="btn-tabla editar"
                                    href="home.php?editar=<?= (int) $fila['id_rombo'] ?>"
                                >
                                    Editar
                                </a>

                                <form
                                    action="home.php"
                                    method="post"
                                    onsubmit="return confirm('¿Desea eliminar este registro?');"
                                >
                                    <input
                                        type="hidden"
                                        name="id_rombo"
                                        value="<?= (int) $fila['id_rombo'] ?>"
                                    >

                                    <button
                                        class="btn-tabla eliminar"
                                        type="submit"
                                        name="accion"
                                        value="eliminar"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>
                    <tr>
                        <td colspan="9">
                            No hay registros para mostrar.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <section id="informacion">
        <h2>Acerca del sistema</h2>
        <p>
            Sistema para calcular y administrar registros del rombo,
            incluyendo sus diagonales, lado, área y perímetro.
        </p>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const diagonalMayor = document.getElementById('txtDiagonalMayor');
    const diagonalMenor = document.getElementById('txtDiagonalMenor');
    const lado = document.getElementById('txtLado');
    const area = document.getElementById('txtA');
    const perimetro = document.getElementById('txtP');
    const botonCalcular = document.getElementById('btnCalcular');
    const formulario = document.getElementById('frmFormulario');

    function calcularRombo() {
        const D = Number(diagonalMayor.value);
        const d = Number(diagonalMenor.value);

        if (
            !diagonalMayor.value ||
            !diagonalMenor.value ||
            !Number.isFinite(D) ||
            !Number.isFinite(d) ||
            D <= 0 ||
            d <= 0
        ) {
            lado.value = '';
            area.value = '';
            perimetro.value = '';
            return false;
        }

        if (D < d) {
            lado.value = '';
            area.value = '';
            perimetro.value = '';
            return false;
        }

        const l = Math.sqrt((D / 2) ** 2 + (d / 2) ** 2);
        const a = (D * d) / 2;
        const p = 4 * l;

        lado.value = l.toFixed(2);
        area.value = a.toFixed(2);
        perimetro.value = p.toFixed(2);

        return true;
    }

    botonCalcular.addEventListener('click', function () {
        if (!calcularRombo()) {
            alert('Ingrese diagonales válidas. La diagonal mayor debe ser mayor o igual que la menor.');
        }
    });

    diagonalMayor.addEventListener('input', calcularRombo);
    diagonalMenor.addEventListener('input', calcularRombo);

    formulario.addEventListener('submit', function (evento) {
        if (!calcularRombo()) {
            evento.preventDefault();
            alert('Verifique las diagonales antes de guardar.');
        }
    });

    calcularRombo();
});
</script>

</body>
</html>
