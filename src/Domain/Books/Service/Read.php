<?php

namespace App\Domain\Books\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Organization\Repository\OrganizationFinderRepository as OrganizationFinder;
use App\Domain\Selection\Repository\SelectionFinderRepository as SelectionFinder;
use App\Domain\Library\Repository\LibraryFinderRepository as LibraryFinder;
use App\Domain\Employee\Repository\EmployeeFinderRepository as EmployeeFinder;

/**
 * Service.
 */
final class Read{

    private $language;

    private $organizationFinderRepository;

    private $selectionFinder;

    private $libraryFinder;

    private $employeeFinder;

    /**
     * The constructor.
     *
     */
    public function __construct(OrganizationFinder $organizationFinderRepository,
                                SelectionFinder $selectionFinder,
                                LibraryFinder $libraryFinder,
                                EmployeeFinder $employeeFinder) {
        $this->language = new Language();
        $this->organizationFinderRepository = $organizationFinderRepository;
        $this->selectionFinder = $selectionFinder;
        $this->libraryFinder = $libraryFinder;
        $this->employeeFinder = $employeeFinder;
    }

    /**
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $bin, string $lang, ?string $search = null): array{
        $this->language->locale($lang);
        $orgInfo = $this->organizationFinderRepository->findByBin($bin, $lang);
        if(empty($orgInfo)) return array();

        $this->selectionFinder->tableName.=$bin;
        $this->libraryFinder->tableName.=$bin;
        $selection = $this->selectionFinder->getMostViews($lang);
        $limit = (int)$selection["max_count"];
        $books = $this->libraryFinder->getAllByView($limit);
        $array = array(
            "bin" => $bin,
            "lang" => $lang,
            "title" => $orgInfo["name"],
            "most_viewed_list" => $books,
            "hello" => $this->language->get("string")["hello"].$search,
            "about_library" => $this->language->get("string")["about_library"],
            "real_book_count_s" => $this->language->get("string")["real_book_count_s"],
            "real_book_count" => $orgInfo["real_book_count"],
            "most_viewed" => $this->language->get("string")["most_viewed"],
            "books_list_title" => $this->language->get("string")["books_list_title"],
            "search" => $this->language->get("string")["search"],
            "books" => $this->libraryFinder->search(),
            "employees" => $this->employeeFinder->getByBin($lang, $bin),
            "e_book_count_s" => $this->language->get("string")["e_book_count_s"],
            "e_book_count" => $this->libraryFinder->getCount()
        );
        return $array;
    }
}