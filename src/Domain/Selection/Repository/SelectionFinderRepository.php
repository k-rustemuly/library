<?php

namespace App\Domain\Selection\Repository;

use App\Factory\QueryFactory;
use App\Domain\Book\Repository\BookFinderRepository;
use PDOException;

/**
 * Repository.
 */
final class SelectionFinderRepository {
    /**
     * @var string
     */
    public $tableName = "selection_";

    /**
     * @var QueryFactory
     */
    private $queryFactory;

    /**
     * Constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory) {
        $this->queryFactory = $queryFactory;
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function getAll(): array{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["l.*",
                        "b.image", "b.name", "b.published_year",])
        ->innerJoin(["b" => BookFinderRepository::$tableName], ["b.isbn = l.isbn"]);
        try{
            return $query->execute()->fetchAll("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }
}
