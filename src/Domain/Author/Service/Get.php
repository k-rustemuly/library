<?php

namespace App\Domain\Author\Service;

use DomainException;
use App\Helper\Language;
use App\Helper\Admin;

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
     * The constructor.
     *
     */
    public function __construct() {
        $this->language = new Language();
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
            "add" => $l->getString("add"),
        );
        return array_merge($array, $base);
    }
}