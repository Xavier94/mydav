<?php

use Phalcon\Mvc\Collection;

class Files extends Collection
{
    /**
     * For change the mapping collection.
     *
     * @return string Name of collection
     */
    public function getSource()
    {
        return 'files';
    }
}
