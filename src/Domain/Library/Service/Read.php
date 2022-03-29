<?php

namespace App\Domain\Library\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Library\Repository\LibraryFinderRepository as ReadRepository;
use SlimSession\Helper as Session;

/**
 * Service.
 */
final class Read extends Admin{

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
     * @var Session 
     *
     */
    private $session;

    /**
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository) {
        $this->language = new Language();
        $this->readRepository = $readRepository;
        $this->session = new Session();
        $this->readRepository->tableName = $this->readRepository->tableName.$this->session->get("admin")["organization_bin"];
    }

    /**
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $lang): array{
        $l = $this->language;
        $l->locale($lang);
        $base = $this->getBase($lang);
        $array = array(
            "title" => $l->getTitle("library"),
            "h1" => $l->getString("library_h1"),
            "search" => $l->getString("search"),
            "add_new" => $l->getString("add_new_library"),
            "tags" => $l->getField("tags"),
            "pdf" => $l->getField("pdf"),
            "view_count" => $l->getString("view_count"),
            "count" => $l->getField("count"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait"),
            "list" => $this->readRepository->getAll()
        );
        return array_merge($array, $base);
    }
}