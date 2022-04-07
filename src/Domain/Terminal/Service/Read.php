<?php

namespace App\Domain\Terminal\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Organization\Repository\OrganizationFinderRepository as OrganizationFinder;
use App\Domain\Selection\Repository\SelectionFinderRepository as SelectionFinder;
use App\Domain\Library\Repository\LibraryFinderRepository as LibraryFinder;

/**
 * Service.
 */
final class Read extends Admin{

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
        $selections = $this->selectionFinder->getAll($lang);

        foreach($selections as $s => $selection) {
            if($selection["type_id"] == 1) {
                $limit = (int)$selection["max_count"];
                $books = $this->libraryFinder->getAllByView($limit);
                $bookList = array();
                for($i = 0; $i < count($books); $i=$i+6) {
                    $arr = array();
                    for($j=$i; $j<$i+6; $j++) {
                        $arr[] = $books[$j];
                    }
                    $bookList[] = $arr;
                }
                $selections[$s]["list"] = $bookList;
            }
        }
        $array = array(
            "title" => $orgInfo["name"],
            "selection" => $selections
        );
        return $array;
    }
}