<?php

namespace App\Domain\Tag\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Tag\Repository\TagFinderRepository as ReadRepository;

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
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository) {
        $this->language = new Language();
        $this->readRepository = $readRepository;
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
            "title" => $l->getTitle("tag"),
            "h1" => $l->getString("tag_h1"),
            "all" => $l->getString("all"),
            "search" => $l->getString("search"),
            "add_new" => $l->getString("add_new_tag"),
            "name" => $l->getField("name"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait"),
            "list" => $this->readRepository->getAll()
        );
        return array_merge($array, $base);
    }
}