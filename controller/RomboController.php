
<?php

require_once __DIR__ . '/../model/Rombo.php';

class RomboController
{
    private Rombo $modelo;

    public function __construct()
    {
        $this->modelo = new Rombo();
    }

    public function procesarFormulario(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return '';
        }

        $accion = $_POST['accion'] ?? '';

        if ($accion === 'guardar') {
            return $this->guardarOActualizar();
        }

        if ($accion === 'eliminar') {
            return $this->eliminar();
        }

        return '';
    }

    private function guardarOActualizar(): string
    {
        $id = (int) ($_POST['id_rombo'] ?? 0);
        $detalle = trim($_POST['txtDetalle'] ?? '');
        $diagonalMayor = trim($_POST['txtDiagonalMayor'] ?? '');
        $diagonalMenor = trim($_POST['txtDiagonalMenor'] ?? '');

        if ($detalle === '') {
            return 'Ingrese el detalle del rombo';
        }

        if (
            $diagonalMayor === '' ||
            !is_numeric($diagonalMayor) ||
            (float) $diagonalMayor <= 0
        ) {
            return 'Ingrese una diagonal mayor válida';
        }

        if (
            $diagonalMenor === '' ||
            !is_numeric($diagonalMenor) ||
            (float) $diagonalMenor <= 0
        ) {
            return 'Ingrese una diagonal menor válida';
        }

        $diagonalMayor = (float) $diagonalMayor;
        $diagonalMenor = (float) $diagonalMenor;

        if ($diagonalMayor < $diagonalMenor) {
            return 'La diagonal mayor debe ser mayor o igual que la diagonal menor';
        }

        if ($id > 0) {
            $this->modelo->actualizar(
                $id,
                $detalle,
                $diagonalMayor,
                $diagonalMenor
            );

            header('Location: home.php?mensaje=actualizado');
            exit;
        }

        $this->modelo->guardar(
            $detalle,
            $diagonalMayor,
            $diagonalMenor
        );

        header('Location: home.php?mensaje=guardado');
        exit;
    }

    private function eliminar(): string
    {
        $id = (int) ($_POST['id_rombo'] ?? 0);

        if ($id <= 0) {
            return 'No se pudo eliminar el registro';
        }

        $this->modelo->eliminar($id);

        header('Location: home.php?mensaje=eliminado');
        exit;
    }

    public function listar(string $buscar = ''): array
    {
        return $this->modelo->listar($buscar);
    }

    public function obtenerParaEditar(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        return $this->modelo->obtenerPorId($id);
    }
}
