<?php

namespace Admin\CommonBundle\EventListener;

use Admin\CommonBundle\Entity\Interfaces\HasFiles;
use Admin\CommonBundle\Services\Uploader;
use Doctrine\ORM\Event\LifecycleEventArgs;

class FileDeleteListener
{
    private $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }


    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof HasFiles){
            return ;
        }

        $files = $entity->getFileValues();

        foreach($files as $file){
            if(null !== $file){
                $this->uploader->removeFile($entity, $file);
            }
        }
    }
}