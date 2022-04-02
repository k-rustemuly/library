<?php

namespace App\Domain\Selection\Repository;

use App\Factory\QueryFactory;
use PDOException;
use DomainException;

/**
 * Repository.
 */
final class SelectionCreatorRepository {
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
     * Insert row.
     *
     * @param array<mixed> $row The data
     *
     * @return int The inserted ID
     */
    public function insert(array $row): int{
        try {
            return (int) $this->queryFactory->newInsert($this->tableName, $row)->execute()->lastInsertId();
        } catch(PDOException $e) {
            return 0;
        }
    }
}
