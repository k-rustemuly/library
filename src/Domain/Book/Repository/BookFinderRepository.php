<?php

namespace App\Domain\Book\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class BookFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "books";

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
    public function getAll(string $lang): array{
        $query = $this->queryFactory->newSelect(self::$tableName)->select(["*"]);
        return $query->execute()->fetchAll("assoc") ?: [];
    }
}
