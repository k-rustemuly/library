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
            $selections[$s]["d"] = array("a");
            if($selection["type_id"] == 1) {
                $limit = (int)$selection["max_count"];
                $books = $this->libraryFinder->getAllByView($limit);
                $bookList = array();
                for($i = 0; $i < count($books); $i=$i+6) {
                    $arr = array();
                    $c = $i+6 > count($books) ? count($books) : $i+6;
                    for($j=$i; $j < $c; $j++) {
                        $arr[] = $books[$j];
                    }
                    $bookList[] = $arr;
                }
                $selections[$s]["list"] = $bookList;
            } else if ($selection["type_id"] == 2) {
                $tags = $selection["tags"];
                $limit = (int)$selection["max_count"];
                $books = $this->libraryFinder->getAllByTags($limit, $this->parseAndGetTags($tags));
                $selections[$s]["d"] = $this->parseAndGetTags($tags);
                $bookList = array();
                for($i = 0; $i < count($books); $i=$i+6) {
                    $arr = array();
                    $c = $i+6 > count($books) ? count($books) : $i+6;
                    for($j=$i; $j < $c; $j++) {
                        $arr[] = $books[$j];
                    }
                    $bookList[] = $arr;
                }
                $selections[$s]["list"] = $bookList;
            }
        }
        $array = array(
            "bin" => $bin,
            "title" => $orgInfo["name"],
            "selection" => $selections
        );
        return $array;
    }

    private function parseAndGetTags(string $tags) :array{
        $arra = array();
        $ex = explode("@", $tags);
        foreach ($ex as $a) {
            if($a > 0)
                $arra[] = array("l.tags" => "@".$a."@");
        }
        return $arra;
    }
}