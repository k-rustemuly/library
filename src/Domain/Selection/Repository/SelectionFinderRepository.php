<?php

namespace App\Domain\Selection\Repository;

use App\Factory\QueryFactory;
use App\Domain\SelectionType\Repository\SelectionTypeFinderRepository;
use PDOException;

/**
 * Repository.
 */
final class SelectionFinderRepository {
    /**
     * @var string
     */
    public $tableName = "selection_";

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
        $query = $this->queryFactory->newSelect(["s" => $this->tableName]);
        $query->select(["s.id", "s.order_num", "s.name_".$lang." as name", "s.description_".$lang." as description", "s.max_count", "s.is_active", "s.tags",
                        "t.name_".$lang." as type_name",])
        ->innerJoin(["t" => SelectionTypeFinderRepository::$tableName], ["t.id = s.type_id"])
        ->orderAsc("s.order_num");
        try{
            return $query->execute()->fetchAll("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }

    public function getLastOrderNumber() :int{
        $res = $this->queryFactory->newSelect($this->tableName)->select(["order_num"])->orderDesc("order_num")->limit(1)->execute()->fetch("assoc");
        return $res ? (int)$res["order_num"]: 0;
    }

    /**
     *
     * @return array<mixed> The list view data
     */
    public function getAll(string $lang): array{
        $query = $this->queryFactory->newSelect(["s" => $this->tableName]);
        $query->select(["s.name_".$lang." as name", "s.description_".$lang." as description", "s.max_count", "s.isbns", "s.tags", "s.type_id"])
        ->where(["s.is_active" => 1])
        ->orderAsc("s.order_num");
        try{
            return $query->execute()->fetchAll("assoc") ?: [];
        }catch(PDOException $e){
            return [];
        }
    }
}
