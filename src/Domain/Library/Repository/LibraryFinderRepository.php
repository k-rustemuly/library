<?php

namespace App\Domain\Library\Repository;

use App\Factory\QueryFactory;
use App\Domain\Book\Repository\BookFinderRepository;
use PDOException;

/**
 * Repository.
 */
final class LibraryFinderRepository {
    /**
     * @var string
     */
    public $tableName = "library_";

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
