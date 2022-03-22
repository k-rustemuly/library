<?php

namespace App\Domain\Book\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Book\Repository\BookFinderRepository as ReadRepository;

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
            "title" => $l->getTitle("book"),
            "h1" => $l->getString("book_h1"),
            "all" => $l->getString("all"),
            "search" => $l->getString("search"),
            "add_new" => $l->getString("add_new_book"),
            "name" => $l->getField("name"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait"),
            "published_year" => $l->getField("published_year"),
            "page_count" => $l->getField("page_count"),
            "language_code" => $l->getField("language_code"),
            "publisher" => $l->getField("publisher"),
            "authors" => $l->getField("authors"),
            "series" => $l->getField("series"),
            "description" => $l->getField("description"),
            "list" => $this->readRepository->getAll($lang)
        );
        return array_merge($array, $base);
    }
}