<?php

class Database
{
    private static ?Database $instance = null;
    public PDO $pdo;

    private function __construct()
    {
        $dsn = DB_DSN;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $this->pdo = new PDO($dsn, $username, $password, $options);

        if (str_starts_with($dsn, 'sqlite:')) {
            $this->pdo->exec('PRAGMA foreign_keys = ON;');
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function pdo(): PDO
    {
        return self::getInstance()->pdo;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);

        return $stmt->fetchAll();
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }
}
