<?php

namespace App\Command;

use App\Services\DB;

class SyncCommand
{

    /**
     * @var DB
     */
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getCurrentState(): array
    {
        $authors = [];
        $data = $this->db->select("SELECT a.id as author_id, 
                                                a.name as author_name, 
                                                b.id as book_id, 
                                                b.name as book_name
                                        FROM authors a 
                                        LEFT JOIN books b ON a.id = b.author_id
                                        GROUP BY a.name, b.name
                                        ORDER BY a.id, b.id 
        ", []);

        foreach ($data AS $item) {
            if (!isset($authors[$item['author_name']])) {
                $authors[$item['author_name']] = [
                    'id' => $item['author_id'],
                    'books' => []
                ];
            }
            $authors[$item['author_name']]['books'][$item['book_name']] = [
                'id' => $item['book_id'],
                'name' => $item['book_name']
            ];
        }

        return $authors;
    }

    public function sync(array $data = [])
    {

        $currentState = $this->getCurrentState();

        foreach ($data AS $item) {

            if (isset($currentState[$item['author']], $currentState[$item['author']]['books'][$item['name']])) {
                echo "Already exists {$item['author']}: {$item['name']}" . PHP_EOL;
                continue;
            }

            if (!isset($currentState[$item['author']])) {

                $this->db->beginTransaction();

                try {
                    $authorId = $this->db->insert('authors', [
                        'name' => $item['author'],
                        'created_at' => date(\DateTimeImmutable::RFC7231)
                    ]);
                } catch (\PDOException $e) {
                    $this->db->rollBack();
                    echo $e->getMessage();
                    continue;
                }

                $this->db->commit();

                $currentState[$item['author']] = [
                    'id' => $authorId,
                    'books' => []
                ];
            }

            if (!isset($currentState[$item['author']]['books'][$item['name']])) {

                $this->db->beginTransaction();

                try {
                    $bookId = $this->db->insert('books', [
                        'name' => $item['name'],
                        'author_id' => $currentState[$item['author']]['id'],
                        'created_at' => date(\DateTimeImmutable::RFC7231)
                    ]);
                } catch (\PDOException $e) {
                    $this->db->rollBack();
                    echo $e->getMessage();
                    continue;
                }

                $this->db->commit();

                $currentState[$item['author']]['books'][$item['name']] = [
                    'id' => $bookId,
                    'author_id' => $currentState[$item['author']]['id'],
                    'name' => $item['name']
                ];
            }

            echo "Successful added new book: {$item['author']}: {$item['name']}" . PHP_EOL;
        }

        unset($currentState);
    }
}
