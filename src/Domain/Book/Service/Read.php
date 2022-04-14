<?php

namespace App\Domain\Book\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Book\Repository\BookFinderRepository as ReadRepository;
use App\Domain\Author\Repository\AuthorFinderRepository;

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
     * @var array<int>
     * 
     */
    private $author_ids = array();

    /**
     * @var AuthorFinderRepository 
     *
     */
    private $authorFinderRepository;

    /**
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository, AuthorFinderRepository $authorFinderRepository) {
        $this->language = new Language();
        $this->readRepository = $readRepository;
        $this->authorFinderRepository = $authorFinderRepository;
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
            "edit" => $l->getString("edit"),
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
            "image" => $l->getField("image"),
            "list" => $this->getBooks($lang)
        );
        return array_merge($array, $base);
    }

    /**
     * Get list of books
     * 
     * @param string $lang the language
     * 
     * @return array<mixed> The list
     */
    private function getBooks(string $lang) :array{
        $books = $this->readRepository->getAll($lang);
        foreach($books as $i => $book) {
            $author_ids = $book["author_ids"];
            $books[$i]["author_ids"] = $this->parseAuthorIds($author_ids);
        }
        $authors_list = $this->authorFinderRepository->getByIds(array_keys($this->authorIds));
        $authors = array();
        foreach ($authors_list as $author) {
            $authors[$author["id"]] = $author["name"];
        }
        foreach ($books as $i => $book){
            $authors_string = "";
            $ids = $book["author_ids"];
            foreach ($ids as $id) {
                $authors_string.=$authors[$id].", ";
            }
            $books[$i]["authors"] = substr($authors_string, 0, -2);
        }
        return $books;
    }

    /**
     * parse ids and set to array
     * 
     * @param string $ids
     */
    private function parseAuthorIds(string $ids) {
        $array = array();
        $ids = explode('@', $ids);
        foreach ($ids as $id) {
            if($id > 0) {
                $array[] = $id;
                if(!isset($this->authorIds[$id]))
                $this->authorIds[$id] = $id;
            }
        }
        return $array;
    }
}