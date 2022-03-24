<?php

namespace App\Domain\Language\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class LanguageFinderRepository {
    /**
     * @var string
     */
    public static $tableName = "rb_languages";

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
    public function getAllByLang(string $lang): array{
        $query = $this->queryFactory->newSelect(self::$tableName)->select(["code", "name_".$lang." as name"]);
        return $query->execute()->fetchAll("assoc") ?: [];
    }
}
