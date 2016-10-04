<?php

namespace App\Model\Adapters;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
interface IUploadAdapter extends IAdapter {

    public function setFiles($files);

    public function getFiles();

    public function setAdditionalData($data);

    public function getAdditionalData();

    public function upload();

}
