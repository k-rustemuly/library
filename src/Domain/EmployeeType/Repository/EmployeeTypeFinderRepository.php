<?php

namespace App\Domain\EmployeeType\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class EmployeeTypeFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "rb_employee_types";

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
}
