<?php

namespace App\Domain\Library\Repository;

use App\Factory\QueryFactory;
use PDOException;

/**
 * Repository.
 */
final class LibraryUpdaterRepository {
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
     * Update row.
     *
     * @param string $bin The company bin
     * @param int $id The id
     * @param array<mixed> $where The where
     *
     * @return void
     */
    public function updateView(int $id, string $count): int{
        try {
            return (int) $this->queryFactory->newUpdate($this->tableName, ["view_count" => $count])->where(array("id" => $id))->execute()->rowCount();
        } catch(PDOException $e) {
            return 0;
        }
    }
}