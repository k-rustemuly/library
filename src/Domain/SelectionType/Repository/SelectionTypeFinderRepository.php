<?php

namespace App\Domain\SelectionType\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class SelectionTypeFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "rb_selection_types";

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
