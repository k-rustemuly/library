<?php

namespace App\Domain\Book\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Book\Repository\BookCreatorRepository as CreateRepository;
use App\Helper\File;

/**
 * Service.
 */
final class Add extends Admin{
    /**
     * @var CreateRepository 
     *
     */
    private $createRepository;

    /**
     * @var File 
     *
     */
    private $file;

    /**
     * The constructor.
     *
     */
    public function __construct(CreateRepository $createRepository, File $file) {
        $this->language = new Language();
        $this->createRepository = $createRepository;
        $this->file = $file;
    }

    /**
     * Add new
     * 
     * @param array<mixed> $data
     * 
     */
    public function add(array $data, $files = null) {
        $insert = array();
        $uploadedFile = $files['image'];
        if($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $insert["image"] = $this->file->saveFile($uploadedFile, 'image', 'book');
        }
        $isbn = isset($data["isbn"]) && is_numeric($data["isbn"]) && strlen($data["isbn"]) == 13 ? $insert["isbn"] = $data["isbn"] : 0;
        $name = isset($data["name"]) ? $insert["name"] = trim($data["name"]) : null;
        $published_year = isset($data["published_year"]) && is_numeric($data["published_year"]) && strlen($data["published_year"]) == 4  ? $insert["published_year"] = $data["published_year"] : date("Y");
        $page_count = isset($data["page_count"]) && is_numeric($data["page_count"]) && $data["page_count"] > 0 ? $insert["page_count"] = $data["page_count"] : 1;
        $language_code = isset($data["language_code"]) && strlen($data["language_code"]) == 2 ? $insert["language_code"] = $data["language_code"] : "ru";
        $publisher_id = isset($data["publisher_id"]) && is_numeric($data["publisher_id"]) && $data["publisher_id"] > 0 ? $insert["publisher_id"] = $data["publisher_id"] : 0;
        $description = isset($data["description"]) ? $insert["description"] = trim($data["description"]) : null;
        $author_ids = isset($data["author_ids"]) ? $insert["author_ids"] = $data["author_ids"] : null;
        $series_id = isset($data["series_id"]) && is_numeric($data["series_id"]) && $data["series_id"] > 0 ? $insert["series_id"] = $data["series_id"] : 0;
        $this->createRepository->insert($insert);
    }

}