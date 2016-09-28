<?php

namespace App\Model\Adapters;

use \Nette\Http\FileUpload,
    \Nette\Utils\Strings;

/**
 * Base upload adapter
 *
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
abstract class UploadAdapter implements IUploadAdapter {

    /** @var FileUpload[] */
    protected $files;
    protected $additionalData = [];
    protected $errors = [];

    public function getAdditionalData() {
        return $this->additionalData;
    }

    /**
     * @return FileUpload[]
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * @param array $data
     */
    public function setAdditionalData($data) {
        $this->additionalData = $data;
    }

    public function setFiles($files) {
        $this->files = $files;
    }

    public function normalizeFilename($filename) {
        return Strings::webalize($filename);
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function clearErrors() {
        $this->errors = [];
    }

    /**
     * @param string $file
     * @param string|\Exception $error
     */
    public function addError($file, $error) {
        $this->errors[] = ['file' => $file, 'error' => $error];
    }

}
