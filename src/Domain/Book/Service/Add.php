<?php

namespace App\Domain\Book\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Book\Repository\BookFinderRepository as ReadRepository;
use App\Domain\Book\Repository\BookCreatorRepository as CreateRepository;

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
    public function add(array $data, $files = null) {
        $isbn = isset($data["isbn"]) && is_numeric($data["isbn"]) && strlen($data["isbn"]) == 13 ? $data["isbn"] : 0;
        $name = isset($data["name"]) ? trim($data["name"]) : null;
        $published_year = isset($data["published_year"]) && is_numeric($data["published_year"]) && strlen($data["published_year"]) == 4  ? $data["published_year"] : date("Y");
        $page_count = isset($data["page_count"]) && is_numeric($data["page_count"]) && $data["page_count"] > 0 ? $data["page_count"] : 1;
        $language_code = isset($data["language_code"]) && strlen($data["language_code"]) == 2 ? $data["language_code"] : "ru";
        
    }

}