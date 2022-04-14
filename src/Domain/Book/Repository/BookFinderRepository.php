<?php

namespace App\Domain\Book\Repository;

use App\Factory\QueryFactory;
use App\Domain\Language\Repository\LanguageFinderRepository;
use App\Domain\Publisher\Repository\PublisherFinderRepository;
use App\Domain\Series\Repository\SeriesFinderRepository;

/**
 * Repository.
 */
final class BookFinderRepository {
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
     *
     * @return array<mixed> The list view data
     */
    public function getAll(string $lang): array{
        $query = $this->queryFactory->newSelect(["b" => self::$tableName]);
        $query->select(["b.id", "b.isbn", "b.image", "b.name", "b.published_year", "b.page_count", "b.description", "b.author_ids",
                        "l.name_".$lang." as language_name", 
                        "p.name_".$lang." as publisher_name", 
                        "s.name_".$lang." as series_name", ])
        ->innerJoin(["l" => LanguageFinderRepository::$tableName], ["l.code = b.language_code"])
        ->innerJoin(["p" => PublisherFinderRepository::$tableName], ["p.id = b.publisher_id"])
        ->innerJoin(["s" => SeriesFinderRepository::$tableName], ["s.id = b.series_id"]);
        return $query->execute()->fetchAll("assoc") ?: [];
    }

    /**
     * Check exist item on db by ISBN
     * 
     * @param string $isbn
     * 
     * @return bool
     */
    public function existByIsbn(string $isbn) :bool{
        $query = $this->queryFactory->newSelect(self::$tableName)->select(["*"])->where(["isbn" => $isbn]);
        return $query->execute()->fetch("assoc") ? true : false;
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function findByIsbn($isbn): array{
        $query = $this->queryFactory->newSelect(["b" => self::$tableName]);
        $query->select(["b.id", "b.isbn", "b.image", "b.name", "b.published_year", "b.page_count"])
        ->where(["b.isbn" => $isbn]);
        return $query->execute()->fetch("assoc") ?: [];
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function findById($id): array{
        $query = $this->queryFactory->newSelect(["b" => self::$tableName]);
        $query->select(["b.*"])
        ->where(["b.id" => $id]);
        return $query->execute()->fetch("assoc") ?: [];
    }
    
}
