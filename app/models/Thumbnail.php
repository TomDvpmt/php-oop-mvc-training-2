<?php

namespace PhpTraining2\models;

use RuntimeException;

class Thumbnail {

    private const ALLOWED_EXTENSIONS = ["avif", "bmp", "jpg", "jpeg", "png", "webp"];
    private const MAX_SIZE = 1000000;

    private string $fileName = "";
    private int $fileSize = 0;
    private string $fileTmp = "";
    private string $fileExtension = "";
    private string $fileFinalName = "";
    private array $errors = [];


    /**
     * Upload the file
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function upload(): array {
        try {
            $this->checkParameters();

            $this->fileName = $_FILES["thumbnail"]["name"];
            $this->fileSize = $_FILES["thumbnail"]["size"];
            $this->fileTmp = $_FILES["thumbnail"]["tmp_name"];
            
            $fileNameArr = explode(".", $this->fileName);
            $this->fileExtension = strtolower(end($fileNameArr));
            $this->fileFinalName = time() . "_" . $this->fileName;
            
            $this->checkType();
            $this->checkSize();
            $this->checkPermissionOnFolder();

            if(!empty($this->errors)) {
                return ["thumbnail" => false, "errors" => $this->errors];
            } 
            $this->saveFile();
            return ["thumbnail" => $this->fileFinalName, "errors" => []];   
            
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Save the file in the folder
     * 
     * @access private
     * @package PhpTraining2\models
     */

     private function saveFile(): void {
        if(!move_uploaded_file($this->fileTmp, PRODUCTS_THUMBS_DIR . $this->fileFinalName)) {
            throw new RuntimeException("An error occured while saving the file.");
        }
    }

    /**
     * Delete file in the folder
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function deleteFile($path): void {
        unlink($path);
    }

    /**
     * Initial check on the file form input data
     * 
     * @access private
     * @package PhpTraining2\models
     */

    private function checkParameters(): void {
        if (
            !isset($_FILES["thumbnail"]['error']) ||
            is_array($_FILES["thumbnail"]['error'])
        ) {
            throw new RuntimeException('Invalid parameters.');
        }
    }

    /**
     * Check if file's MIME type is authorized
     * 
     * @access private
     * @package PhpTraining2\models
     */

    private function checkType(): void {
        if(!in_array($this->fileExtension, self::ALLOWED_EXTENSIONS)) {
            array_push($this->errors, "Incorrect file format. Allowed formats: avif, bmp, jpg, jpeg, png, webp.");
        }
    }

    /**
     * Check if file size is under maximum authorized
     * 
     * @access private
     * @package PhpTraining2\models
     */

    private function checkSize(): void {
        if($this->fileSize > self::MAX_SIZE) {
            $megaBytes = number_format((float) self::MAX_SIZE / 1000000, 2, ".", ",");
            array_push($this->errors, "File size must not exceed $megaBytes MB.");
        }
    } 

    /**
     * Check if thumbnails folder is writable
     * 
     * @access private
     * @package PhpTraining2\models
     */

    private function checkPermissionOnFolder(): void {
        if(!is_writable(PRODUCTS_THUMBS_DIR)) {
            throw new RuntimeException("The products thumbnails directory is not writable.");
        }
    }
    
}