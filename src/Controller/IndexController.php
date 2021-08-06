<?php

namespace App\Controller;

use App\Services\Controller;

class IndexController extends Controller
{

    public function __invoke()
    {

        $query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);

        $results = $this->getDB()->select("SELECT
            a.id as author_id,
            a.name as author_name,
            b.id as book_id,
            b.name as book_name
        FROM authors a 
        LEFT JOIN books b ON a.id = b.author_id
        WHERE lower(a.name) SIMILAR TO :query
        ORDER BY a.id ASC, a.created_at DESC", ['query' => '%' . mb_strtolower($query) . '%']);

        return $this->renderView('homepage.php', [
            'query' => $query,
            'results' => $results
        ]);
    }
}
