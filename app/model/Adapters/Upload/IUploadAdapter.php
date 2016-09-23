<?php

namespace App\Model\Adapters;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
interface IUploadAdapter {

    public function setFiles($files);

    public function getFiles();

    public function setAdditionalData(Array $data);

    public function getAdditionalData();

    public function upload();

}
