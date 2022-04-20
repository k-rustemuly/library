<?php

namespace App\Domain\Books\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Organization\Repository\OrganizationFinderRepository as OrganizationFinder;
use App\Domain\Selection\Repository\SelectionFinderRepository as SelectionFinder;
use App\Domain\Library\Repository\LibraryFinderRepository as LibraryFinder;

/**
 * Service.
 */
final class Read{

    private $language;

    private $organizationFinderRepository;

    private $selectionFinder;

    private $libraryFinder;

    /**
     * The constructor.
     *
     */
    public function __construct(OrganizationFinder $organizationFinderRepository, SelectionFinder $selectionFinder, LibraryFinder $libraryFinder) {
        $this->language = new Language();
        $this->organizationFinderRepository = $organizationFinderRepository;
        $this->selectionFinder = $selectionFinder;
        $this->libraryFinder = $libraryFinder;
    }

    /**
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $bin, string $lang): array{
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
            "title" => $orgInfo["name"],
            "most_viewed_list" => $books
        );
        return $array;
    }
}