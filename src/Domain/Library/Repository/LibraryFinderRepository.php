<?php

namespace App\Domain\Library\Repository;

use App\Factory\QueryFactory;
use App\Domain\Book\Repository\BookFinderRepository;
use PDOException;

/**
 * Repository.
 */
final class LibraryFinderRepository {
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
     *
     * @return array<mixed> The list view data
     */
    public function getAll(): array{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["l.*",
                        "b.image", "b.name", "b.published_year",])
        ->innerJoin(["b" => BookFinderRepository::$tableName], ["b.isbn = l.isbn"]);
        try{
            return $query->execute()->fetchAll("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function getAllByView(int $limit = 0): array{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["b.image", "b.name", "b.isbn", "b.description", "b.published_year"])
        ->innerJoin(["b" => BookFinderRepository::$tableName], ["b.isbn = l.isbn"])
        ->orderDesc("l.view_count")
        ->limit($limit);
        try{
            return $query->execute()->fetchAll("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function findByIsbn(string $isbn ): array{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["l.id", "l.view_count", "b.name", "l.pdf"])
        ->innerJoin(["b" => BookFinderRepository::$tableName], ["b.isbn = l.isbn"])
        ->where(["l.isbn" => $isbn]);
        try{
            return $query->execute()->fetch("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function getAllByTags(int $limit = 0, array $tags = array()): array{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["b.image", "b.name", "b.isbn", "b.description", "b.published_year"])
        ->innerJoin(["b" => BookFinderRepository::$tableName], ["b.isbn = l.isbn"])
        ->where($tags)
        ->limit($limit);
        try{
            //return array((string) $query);
            return $query->execute()->fetchAll("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function findById( $id ): array{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["l.*"])->where(["l.id" => $id]);
        try{
            return $query->execute()->fetch("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function search(?string $search = null, int $limit = 0): array{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["b.image", "b.name", "b.isbn", "b.description", "b.published_year", "l.view_count"])
        ->innerJoin(["b" => BookFinderRepository::$tableName], ["b.isbn = l.isbn"]);
        if($search != null) {
            $query->where(['OR' => ["b.name LIKE" => "%".$search."%", "b.description LIKE" => "%".$search."%"]]);
        }
        if($limit > 0 ) $query->limit($limit);
        try{
            return $query->execute()->fetchAll("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function getCount(): int{
        $query = $this->queryFactory->newSelect(["l" => $this->tableName]);
        $query->select(["COUNT(l.id) as counter"]);
        try{
            return (int)$query->execute()->fetch("assoc")["counter"] ?: 0;
        }catch(PDOException $e){
            return 0;
        }
    }
}
