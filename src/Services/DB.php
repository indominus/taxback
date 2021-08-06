<?php

namespace App\Services;

use PDO;

class DB extends PDO
{

    public function __construct($dsn, $username = null, $password = null, $options = null)
    {
        parent::__construct($dsn, $username, $password, $options);

        $this->setAttribute(self::ATTR_EMULATE_PREPARES, false);
        $this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
    }

    public function select($query, array $data = [], $fetchMode = PDO::FETCH_ASSOC): array
    {
        $statement = $this->prepare($query);
        $statement->execute($data);

        return $statement->fetchAll($fetchMode);
    }

    public function selectOnce($query, array $data = []): array
    {
        $statement = $this->prepare($query);
        foreach ($data as $column => $value) {
            $statement->bindColumn($column, $value);
        }
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    private function getNextVal($sequence)
    {
        $query = $this->query("SELECT nextval('{$sequence}') AS id");
        return $query->fetchColumn();
    }

    public function insert($table, array $data = []): string
    {
        $sequence = $table . '_id_seq';

        $query = "INSERT INTO {$table} (id, %s) VALUES (:id, %s)";
        $keys = implode(',', array_keys($data));
        $names = implode(',', array_map(function ($name) {
            return ":{$name}";
        }, array_keys($data)));

        $statement = $this->prepare(sprintf($query, $keys, $names));

        $data['id'] = $this->getNextVal($sequence);

        $statement->execute($data);

        return $this->lastInsertId($sequence);
    }

    public function update($table, array $data = [], array $filter = [])
    {
        //@ToDo Update method logic
    }

    public function delete($table, array $filter = [])
    {
        //@ToDo Update method logic
    }
}
