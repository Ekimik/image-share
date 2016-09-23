<?php

namespace App\Forms;

use \App\Models\Adapters\IUploadAdapter;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
interface IUploadForm extends IAppForm {

    /**
     * @return IUploadAdapter[]
     */
    public function getAdapterChain();

    /**
     * @param IUploadAdapter[] $chain
     */
    public function setAdapterChain(Array $chain);

    /**
     * @param int $i
     * @return IUploadAdapter
     */
    public function getAdapterFromChain($i);

}
