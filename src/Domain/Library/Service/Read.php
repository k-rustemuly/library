<?php

namespace App\Domain\Library\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Library\Repository\LibraryFinderRepository as ReadRepository;
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
            "title" => $l->getTitle("library"),
            "h1" => $l->getString("library_h1"),
            "search" => $l->getString("search"),
            "add_new" => $l->getString("add_new_library"),
            "tags" => $l->getField("tags"),
            "pdf" => $l->getField("pdf"),
            "view_count" => $l->getString("view_count"),
            "count" => $l->getField("count"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait"),
            "list" => $this->getLibrary($lang)
        );
        return array_merge($array, $base);
    }

    /**
     * Get list of books on library
     * 
     * @param string $lang the language
     * 
     * @return array<mixed> The list
     */
    private function getLibrary(string $lang) :array{
        $library_list = $this->readRepository->getAll($lang);
        foreach($library_list as $i => $item) {
            $tags = $item["tags"];
            $library_list[$i]["tags"] = $this->parseTags($tags);
        }
        $list = $this->tagFinderRepository->getByIds(array_keys($this->tags));
        $tags = array();
        foreach ($list as $tag) {
            $tags[$tag["id"]] = $tag["name"];
        }
        foreach ($library_list as $i => $item){
            $string = "";
            $ids = $item["tags"];
            foreach ($ids as $id) {
                $string.=$tags[$id].", ";
            }
            $library_list[$i]["tags"] = substr($string, 0, -2);
        }
        return $library_list;
    }

    /**
     * parse ids and set to array
     * 
     * @param string $ids
     */
    private function parseTags(string $ids) {
        $array = array();
        $ids = explode('@', $ids);
        foreach ($ids as $id) {
            if($id > 0) {
                $array[] = $id;
                if(!isset($this->tags[$id]))
                $this->tags[$id] = $id;
            }
        }
        return $array;
    }
}