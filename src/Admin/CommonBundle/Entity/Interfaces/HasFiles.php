<?php

namespace Admin\CommonBundle\Entity\Interfaces;


interface HasFiles
{
    public function getUploadDir();
    public function getWebPath($file);

    /**
     * @return array
     */
    public function getFileValues();
}