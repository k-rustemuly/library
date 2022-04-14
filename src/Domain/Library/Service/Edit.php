<?php

namespace App\Domain\Library\Service;

use App\Helper\Admin;
use App\Domain\Library\Repository\LibraryUpdaterRepository as UpdaterRepository;
use SlimSession\Helper as Session;
use App\Helper\File;
use DomainException;

/**
 * Service.
 */
final class Edit extends Admin{
    /**
     * @var UpdaterRepository 
     *
     */
    private $updaterRepository;

    /**
     * @var File 
     *
     */
    private $file;

    /**
     * The constructor.
     *
     */
    public function __construct(UpdaterRepository $updaterRepository, File $file) {
        $session = new Session();
        $this->updaterRepository = $updaterRepository;
        $this->file = $file;
        $this->updaterRepository->tableName = $this->updaterRepository->tableName.$session->get("admin")["organization_bin"];
    }

    /**
     * Add new
     * 
     * @throws DomainException
     * 
     * @param array<mixed> $data
     * 
     */
    public function save(array $data, $files = null) {
        $update = array();
        $uploadedFile = $files['pdf'];
        if($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $update["pdf"] = $this->file->saveFile($uploadedFile, 'pdf', 'book');
        }
        $count = isset($data["count"]) && $data["count"] >= 0 ? $update["count"] = $data["count"] : "";
        $tag_ids = isset($data["tag_ids"]) && $data["tag_ids"] != "@" ? $update["tags"] = trim($data["tag_ids"]) : "";
        $this->updaterRepository->updateId((int)$data["id"], $update);
    }
}