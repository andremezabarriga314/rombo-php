<?php
require_once __DIR__ . '/../config/Database.php';

class Rombo
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->conectar();
    }

    public function listar(string $buscar = ''): array
    {
        if ($buscar !== '') {
            $sql = "SELECT * FROM rombo
                    WHERE detalle LIKE :buscarDetalle
                       OR CAST(diagonal_mayor AS CHAR) LIKE :buscarMayor
                       OR CAST(diagonal_menor AS CHAR) LIKE :buscarMenor
                       OR CAST(lado AS CHAR) LIKE :buscarLado
                       OR CAST(area AS CHAR) LIKE :buscarArea
                       OR CAST(perimetro AS CHAR) LIKE :buscarPerimetro
                    ORDER BY id_rombo DESC";

            $stmt = $this->pdo->prepare($sql);

            $valor = '%' . $buscar . '%';

            $stmt->execute([
                'buscarDetalle'   => $valor,
                'buscarMayor'     => $valor,
                'buscarMenor'     => $valor,
                'buscarLado'      => $valor,
                'buscarArea'      => $valor,
                'buscarPerimetro' => $valor,
            ]);

            return $stmt->fetchAll();
        }

        $sql = "SELECT * FROM rombo ORDER BY id_rombo DESC";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM rombo WHERE id_rombo = :id LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $registro = $stmt->fetch();

        return $registro ?: null;
    }

    public function guardar(
        string $detalle,
        float $diagonalMayor,
        float $diagonalMenor
    ): bool {
        [$lado, $area, $perimetro] = $this->calcular($diagonalMayor, $diagonalMenor);

        $sql = "INSERT INTO rombo
                    (detalle, diagonal_mayor, diagonal_menor, lado, area, perimetro)
                VALUES
                    (:detalle, :mayor, :menor, :lado, :area, :perimetro)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'detalle'   => $detalle,
            'mayor'     => $diagonalMayor,
            'menor'     => $diagonalMenor,
            'lado'      => $lado,
            'area'      => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function actualizar(
        int $id,
        string $detalle,
        float $diagonalMayor,
        float $diagonalMenor
    ): bool {
        [$lado, $area, $perimetro] = $this->calcular($diagonalMayor, $diagonalMenor);

        $sql = "UPDATE rombo
                SET detalle = :detalle,
                    diagonal_mayor = :mayor,
                    diagonal_menor = :menor,
                    lado = :lado,
                    area = :area,
                    perimetro = :perimetro
                WHERE id_rombo = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id'        => $id,
            'detalle'   => $detalle,
            'mayor'     => $diagonalMayor,
            'menor'     => $diagonalMenor,
            'lado'      => $lado,
            'area'      => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM rombo WHERE id_rombo = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    private function calcular(float $diagonalMayor, float $diagonalMenor): array
    {
        $area = ($diagonalMayor * $diagonalMenor) / 2;
        $lado = sqrt(pow($diagonalMayor / 2, 2) + pow($diagonalMenor / 2, 2));
        $perimetro = 4 * $lado;

        return [$lado, $area, $perimetro];
    }
}