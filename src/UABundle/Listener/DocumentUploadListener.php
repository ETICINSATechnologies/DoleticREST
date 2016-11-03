<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 11/3/16
 * Time: 5:42 PM
 */

namespace UABundle\Listener;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use UABundle\Entity\Document;
use KernelBundle\Service\FileUploader;

class DocumentUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $fileName = $entity->getBrochure();

        $entity->setBrochure(new File($this->uploader->getTargetDir().'/'.$fileName));
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof Document) {
            return;
        }

        $file = $entity->getFile();

        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setFile($fileName);
    }
}