<?php

namespace App\Domain\Selection\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Selection\Repository\SelectionFinderRepository as ReadRepository;
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
            "title" => $l->getTitle("selection"),
            "h1" => $l->getString("selection_h1"),
            "search" => $l->getString("search"),
            "add_new" => $l->getString("add_new_selection"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait"),
            "name_ru" => $l->getField("name_ru"),
            "name_kk" => $l->getField("name_kk"),
            "description_ru" => $l->getField("description_ru"),
            "description_kk" => $l->getField("description_kk"),
            "type" => $l->getField("type"),
            "max_book_show" => $l->getField("max_book_show"),
            "tags" => $l->getField("tags"),
            "list" => $this->getList($lang)
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
    private function getList(string $lang) :array{
        $list = $this->readRepository->getAllByLang($lang);
        foreach($list as $i => $item) {
            $tags = $item["tags"];
            $list[$i]["tags"] = $this->parseTags($tags);
        }
        $tag_list = $this->tagFinderRepository->getByIds(array_keys($this->tags));
        $tags = array();
        foreach ($tag_list as $tag) {
            $tags[$tag["id"]] = $tag["name"];
        }
        foreach ($list as $i => $item){
            $string = "";
            $ids = $item["tags"];
            foreach ($ids as $id) {
                $string.=$tags[$id].", ";
            }
            $list[$i]["tags"] = substr($string, 0, -2);
        }
        return $list;
    }

    /**
     * parse ids and set to array
     * 
     * @param string $ids
     */
    private function parseTags(string $ids) {
        $array = array();
        if($ids == null) return $array;
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