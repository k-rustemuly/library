<?php

namespace App\Domain\Organization\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class OrganizationFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "organizations";

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
     * @param string $bin
     * 
     * @return boolean
     */
    public function findByBin(string $bin, string $lang = "ru"): array{
        $query = $this->queryFactory->newSelect(self::$tableName)->select(["id", "name_".$lang." as name", "full_name_".$lang." as full_name", "real_book_count"])->where(["bin" => $bin]);
        return $query->execute()->fetch("assoc")?: [];
    }
}
