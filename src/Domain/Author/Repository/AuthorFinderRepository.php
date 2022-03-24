<?php

namespace App\Domain\Author\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class AuthorFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "rb_authors";

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
     *
     * @return array<mixed> The list view data
     */
    public function getAllWithoutHash(): array{
        $query = $this->queryFactory->newSelect(self::$tableName)->select(["id as value", "avatar", "name"]);
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
