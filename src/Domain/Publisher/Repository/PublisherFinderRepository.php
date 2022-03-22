<?php

namespace App\Domain\Publisher\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class PublisherFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "rb_publishers";

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
        $query = $this->queryFactory->newSelect(self::$tableName)->select(["*"]);
        return $query->execute()->fetchAll("assoc") ?: [];
    }

    /**
     * @param string $hash
     * 
     * @return boolean
     */
    public function existsbyHash(string $hash): bool{
        $query = $this->queryFactory->newSelect(self::$tableName)->select(["*"])->where(["hash" => $hash]);
        return !empty($query->execute()->fetch("assoc"));
    }
}
