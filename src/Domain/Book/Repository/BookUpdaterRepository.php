<?php

namespace App\Domain\Book\Repository;

use App\Factory\QueryFactory;
use PDOException;

/**
 * Repository.
 */
final class BookUpdaterRepository {
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
     * Update row.
     *
     * @param string $iin The iin
     * @param array<mixed> $where The where
     *
     * @return int
     */
    public function updateById($id, array $data = array()): int{
        try {
            return (int) $this->queryFactory->newUpdate(self::$tableName, $data)->where(array("id" => $id))->execute()->rowCount();
        } catch(PDOException $e) {
            return 0;
        }
    }
}
