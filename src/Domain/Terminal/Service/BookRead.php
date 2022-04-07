<?php

namespace App\Domain\Terminal\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Organization\Repository\OrganizationFinderRepository as OrganizationFinder;
use App\Domain\Library\Repository\LibraryFinderRepository as LibraryFinder;

/**
 * Service.
 */
final class BookRead extends Admin{

    private $language;

    private $organizationFinderRepository;

    private $libraryFinder;

    /**
     * The constructor.
     *
     */
    public function __construct(OrganizationFinder $organizationFinderRepository, LibraryFinder $libraryFinder) {
        $this->language = new Language();
        $this->organizationFinderRepository = $organizationFinderRepository;
        $this->libraryFinder = $libraryFinder;
    }

    /**
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $bin, string $lang, string $isbn): array{
        $this->language->locale($lang);
        $orgInfo = $this->organizationFinderRepository->findByBin($bin, $lang);
        if(empty($orgInfo)) return array();

        $this->libraryFinder->tableName.=$bin;
        $book = $this->libraryFinder->findByIsbn($isbn);
        if(empty($book)) return array();
        $name = $book["name"];
        $file = $book["pdf"];
        $array = array(
            "bin" => $bin,
            "title" => $name,
            "file" => $file,
        );
        return $array;
    }
}