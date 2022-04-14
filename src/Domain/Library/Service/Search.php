<?php

namespace App\Domain\Library\Service;

use App\Helper\Admin;
use App\Domain\Library\Repository\LibraryFinderRepository as ReadRepository;
use SlimSession\Helper as Session;

/**
 * Service.
 */
final class Search extends Admin{

    /**
     * @var ReadRepository 
     *
     */
    private $readRepository;

    /**
     * @var Session 
     *
     */
    private $session;

    /**
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository) {
        $this->readRepository = $readRepository;
        $this->session = new Session();
        $this->readRepository->tableName = $this->readRepository->tableName.$this->session->get("admin")["organization_bin"];
    }

    public function search(array $params): array{
        if(isset($params["id"]) && $params["id"] > 0 ) return $this->readRepository->findById($params["id"]);
    }

}