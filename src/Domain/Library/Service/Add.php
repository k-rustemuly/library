<?php

namespace App\Domain\Library\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Book\Repository\BookFinderRepository as ReadRepository;
use App\Domain\Library\Repository\LibraryCreatorRepository as CreateRepository;
use SlimSession\Helper as Session;
use App\Helper\File;
use DomainException;

/**
 * Service.
 */
final class Add extends Admin{

    /**
     * @var ReadRepository 
     *
     */
    private $readRepository;

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
    public function __construct(ReadRepository $readRepository, CreateRepository $createRepository, File $file) {
        $session = new Session();
        $this->readRepository = $readRepository;
        $this->createRepository = $createRepository;
        $this->file = $file;
        $this->createRepository->tableName = $this->readRepository->tableName.$session->get("admin")["organization_bin"];
    }

    /**
     * Add new
     * 
     * @throws DomainException
     * 
     * @param array<mixed> $data
     * 
     */
    public function add(array $data, $files = null) {
        $insert = array();
        $uploadedFile = $files['pdf'];
        $isbn = isset($data["isbn"]) ? $insert["isbn"] = $data["isbn"] : "";
        if(!$this->readRepository->existByIsbn($isbn)) {
            throw new DomainException("Book not found by Isbn");
        }
        if($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $insert["pdf"] = $this->file->saveFile($uploadedFile, 'pdf', 'book');
        }
        $count = isset($data["count"]) && $data["count"] >= 0 ? $insert["count"] = $data["count"] : "";
        $tag_ids = isset($data["tag_ids"]) && $data["tag_ids"] != "@" ? $insert["tag_ids"] = trim($data["tag_ids"]) : "";
        $this->createRepository->insert($insert);
    }
}