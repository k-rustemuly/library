<?php

namespace App\Domain\Selection\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Selection\Repository\SelectionFinderRepository as ReadRepository;
use SlimSession\Helper as Session;
use App\Domain\Tag\Repository\TagFinderRepository;

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
     * @var array<int>
     * 
     */
    private $tags = array();

    /**
     * @var TagFinderRepository 
     *
     */
    private $tagFinderRepository;

    /**
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository, TagFinderRepository $tagFinderRepository) {
        $this->language = new Language();
        $this->readRepository = $readRepository;
        $this->session = new Session();
        $this->readRepository->tableName = $this->readRepository->tableName.$this->session->get("admin")["organization_bin"];
        $this->tagFinderRepository = $tagFinderRepository;
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
            "title" => $l->getTitle("selection"),
            "h1" => $l->getString("selection_h1"),
            "search" => $l->getString("search"),
            "add_new" => $l->getString("add_new_selection"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait")
        );
        return array_merge($array, $base);
    }
}