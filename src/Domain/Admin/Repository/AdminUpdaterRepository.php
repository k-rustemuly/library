<?php

namespace App\Domain\Admin\Repository;

use App\Factory\QueryFactory;
use PDOException;

/**
 * Repository.
 */
final class AdminUpdaterRepository {

    /**
     * @var string
     */
    public static $tableName = "admins";

    /**
     * @var QueryFactory The query factory
     */
    private $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory) {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Update 
     *
     * @param int $id The id
     *
     * @return void
     */
    public function updateLastVisitById(int $id): int{
        try {
            return (int) $this->queryFactory->newUpdate(self::$tableName, array("last_visit" => date("Y-m-d H:i:s")))->where(["id" => $id])->execute()->rowCount();
        } catch(PDOException $e) {
            return 0;
        }
    }
}
