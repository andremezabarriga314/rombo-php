
<?php

class Database
{
    private string $host = '127.0.0.1';
    private string $port = '3306';
    private string $db = 'rombo_db';
    private string $user = 'root';
    private string $pass = '';
    private string $charset = 'utf8mb4';

    public function conectar(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset={$this->charset}";

            return new PDO(
                $dsn,
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die(
                'Error de conexión a la base de datos: ' .
                htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')
            );
        }
    }
}
