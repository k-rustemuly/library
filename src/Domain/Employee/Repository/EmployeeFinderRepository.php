<?php

namespace App\Domain\Employee\Repository;

use App\Factory\QueryFactory;
use App\Domain\EmployeeType\Repository\EmployeeTypeFinderRepository;

/**
 * Repository.
 */
final class EmployeeFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "employee";

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
    public function getByBin(string $lang, string $bin): array{
        $query = $this->queryFactory->newSelect(["e" => self::$tableName]);
        $query->select(["e.id", "t.name_".$lang." as type_name", "e.full_name_".$lang." as full_name", "e.about_".$lang." as about"])
        ->innerJoin(["t" => EmployeeTypeFinderRepository::$tableName], ["t.id = e.employee_type_id"])
        ->where(["e.organization_bin" => $bin])
        ->orderAsc("e.employee_type_id");
        return $query->execute()->fetchAll("assoc") ?: [];
    }
}
