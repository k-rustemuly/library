<?php

namespace App\Domain\Author\Service;

use DomainException;
use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Author\Repository\AuthorFinderRepository as ReadRepository;

/**
 * Service.
 */
final class Get extends Admin{

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
     * Sign in
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
            "title" => $l->getTitle("author"),
            "h1" => $l->getString("author_h1"),
            "all" => $l->getString("all"),
            "search" => $l->getString("search"),
            "add_new_author" => $l->getString("add_new_author"),
            "avatar" => $l->getString("avatar"),
            "change_avatar" => $l->getString("change_avatar"),
            "cancel_avatar" => $l->getString("cancel_avatar"),
            "remove_avatar" => $l->getString("remove_avatar"),
            "full_name" => $l->getField("full_name"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait"),
            "authors_list" => $this->readRepository->getAll()
        );
        return array_merge($array, $base);
    }
}