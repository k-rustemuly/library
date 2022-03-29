<?php

namespace App\Domain\Library\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Library\Repository\LibraryFinderRepository as ReadRepository;
use App\Domain\Library\Repository\LibraryCreatorRepository as CreateRepository;

/**
 * Service.
 */
final class Add extends Admin{

    /**
     * @var Language language
     *
     */
    private $language;

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
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository, CreateRepository $createRepository) {
        $this->language = new Language();
        $this->readRepository = $readRepository;
        $this->createRepository = $createRepository;
    }

    /**
     * Add new
     * 
     * @param array<mixed> $data
     * 
     */
    public function add(array $data) {
        $name = isset($data["name"]) ? $data["name"] : "";
    }
}