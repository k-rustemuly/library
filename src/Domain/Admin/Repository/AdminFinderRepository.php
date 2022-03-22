<?php

namespace App\Domain\Admin\Repository;

use App\Factory\QueryFactory;
use App\Domain\Organization\Repository\OrganizationFinderRepository;

/**
 * Repository.
 */
final class AdminFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "admins";

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
     * Find by email
     *
     * @param string $email The email address
     *
     * @return array<mixed> The list view data
     */
    public function findByEmail(string $email): array{
        $query = $this->queryFactory->newSelect(["a" => self::$tableName]);
        $query->select(["a.*",
                        "o.name_kk", "o.name_ru", "o.is_active as org_is_active"])
        ->innerJoin(["o" => OrganizationFinderRepository::$tableName], ["o.bin = a.organization_bin"])
        ->where(["a.email" => $email]);
        return $query->execute()->fetch("assoc") ?: [];
    }
}
