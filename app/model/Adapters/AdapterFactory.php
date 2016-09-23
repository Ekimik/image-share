<?php

namespace App\Model\Adapters;

use \Nette\Object,
    \Nette\Utils\Strings,
    \App\Model\Exceptions\InvalidArgumentException;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class AdapterFactory extends Object {

    public function create($name) {
        $name = Strings::lower($name);
        $adapter = NULL;

        if ($name === 'filesystemuploadadapter') {
            $adapter = new FileSystemUploadAdapter();
        } else {
            throw new InvalidArgumentException(sprintf('Unknown adapter %s', $name));
        }

        return $adapter;
    }

}
