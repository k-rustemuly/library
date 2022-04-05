<?php

namespace App\Domain\Selection\Service;

use App\Helper\Admin;
use App\Domain\Selection\Repository\SelectionFinderRepository as ReadRepository;
use App\Domain\Selection\Repository\SelectionCreatorRepository as CreateRepository;
use SlimSession\Helper as Session;
use App\Helper\File;
use DomainException;

/**
 * Service.
 */
final class Add extends Admin{

    /**
     * @var ReadRepository 
     *
     */
    private $readRepository;

    /**
     * @var CreateRepository 
     *
     */
    private $createRepository;

    /**
     * @var File 
     *
     */
    private $file;

    /**
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository, CreateRepository $createRepository, File $file) {
        $session = new Session();
        $this->readRepository = $readRepository;
        $this->createRepository = $createRepository;
        $this->file = $file;
        $this->readRepository->tableName = $readRepository->tableName.$session->get("admin")["organization_bin"];
        $this->createRepository->tableName = $this->createRepository->tableName.$session->get("admin")["organization_bin"];
    }

    /**
     * Add new
     * 
     * @throws DomainException
     * 
     * @param array<mixed> $data
     * 
     */
    public function add(array $data) {
        $insert = array();
        $type_id = isset($data["type_id"]) && $data["type_id"] >= 0 ? $insert["type_id"] = $data["type_id"] : "";
        $name_ru = isset($data["name_ru"]) ? $insert["name_ru"] = trim($data["name_ru"]) : "";
        $description_ru = isset($data["description_ru"]) ? $insert["description_ru"] = trim($data["description_ru"]) : "";
        $name_kk = isset($data["name_kk"]) ? $insert["name_kk"] = trim($data["name_kk"]) : "";
        $description_kk = isset($data["description_kk"]) ? $insert["description_kk"] = trim($data["description_kk"]) : "";
        $max_count = isset($data["max_count"]) && $data["max_count"] >= 0 ? $insert["max_count"] = trim($data["max_count"]) : "";
        if($type_id == 2)
            $tags = isset($data["tags"]) ? $insert["tags"] = trim($data["tags"]) : "";
        $insert["order_num"] = $this->readRepository->getLastOrderNumber()+1;
        $this->createRepository->insert($insert);
    }
}