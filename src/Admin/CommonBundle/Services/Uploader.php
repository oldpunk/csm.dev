<?php

namespace Admin\CommonBundle\Services;

use Admin\CommonBundle\Entity\Interfaces\HasFiles;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Uploader
{
    private $container;
    private $root_dir;

    public function __construct(ContainerInterface $container, $root_dir)
    {
        $this->container = $container;
        $this->root_dir = $root_dir;
    }


    public function uploadFiles(HasFiles $entity)
    {
        $request = $this->container->get('request');
        $iterator = $request->files->getIterator();
        do{
            $fileArray = $iterator->current();
            $file = current($fileArray);
            $key = $this->getMethodName($fileArray);

            $remove = $request->request->get($this->getDelValue($fileArray));
            $oldfile = call_user_func(array($entity, "get".$key));

            if(null !== $oldfile && null !== $remove){
                $this->removeFile($entity, $oldfile);
                call_user_func_array(array($entity, "set".$key), array(null));
            }

            if(null !== $file) {

                if(null !== $oldfile){
                    $this->removeFile($entity, $oldfile);
                }

                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                $imgDir = $this->root_dir.'/../web/'.$entity->getUploadDir();

                $file->move($imgDir, $fileName);
                call_user_func_array(array($entity, "set".$key), array($fileName));
            }
        }while(null !== $iterator->next());

    }

    public function removeFile(HasFiles $entity, $filename)
    {
        $img = $this->root_dir.'/../web/'.$entity->getWebPath($filename);
        if(is_file($img)){
            unlink($img);
        }
    }

    private function getMethodName($fileArray)
    {
        $key = key($fileArray);
        return ucwords($key);
    }

    private function getDelValue($fileArray)
    {
        return key($fileArray).'_del';
    }


}