<?php

namespace PhpTraining2\models;

use Exception;

class Thumbnail {

    private const ALLOWED_EXTENSIONS = ["avif", "bmp", "jpg", "jpeg", "png", "webp"];
    private const MAX_SIZE = 1000000;

    private string $fileName = "";
    private int $fileSize = 0;
    private string $fileTmp = "";
    private string $fileExtension = "";
    private string $fileFinalName = "";
    private array $errors = [];

    public function __construct()
    {
        try {
            $this->checkParameters();

            $this->fileName = $_FILES["image-file"]["name"];
            $this->fileSize = $_FILES["image-file"]["size"];
            $this->fileTmp = $_FILES["image-file"]["tmp_name"];
            
            $fileNameArr = explode(".", $this->fileName);
            $this->fileExtension = strtolower(end($fileNameArr));
            $this->fileFinalName = time() . "_" . $this->fileName;
            
            $this->checkType();
            $this->checkSize();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get the saved file's name
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function getSavedFileName(): string {
        return $this->fileFinalName;
    }

    /**
     * Upload the file
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function upload(): array {
        try {
            $this->checkPermissionOnFolder();

            if(!empty($this->errors)) {
                return ["success" => false, "errors" => $this->errors];
            } 
            $this->saveFile();
            return ["success" => true, "errors" => []];   
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Initial check on the file form input data
     * 
     * @access private
     * @package PhpTraining2\models
     */

    private function checkParameters(): void {
        if (
            !isset($_FILES["image-file"]['error']) ||
            is_array($_FILES["image-file"]['error'])
        ) {
            throw new Exception('Invalid parameters.');
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
            throw new Exception("The products thumbnails directory is not writable.");
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
            throw new Exception("An error occured while saving the file.");
        }
    }

    
}