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
}
