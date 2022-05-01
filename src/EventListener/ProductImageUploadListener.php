<?php

namespace App\EventListener;

use App\Service\ResizeProductImage;
use Vich\UploaderBundle\Event\Event;


class ProductImageUploadListener
{
    protected const MAPPING_NAME = 'product_images';

    public function onVichUploaderPostUpload(Event $event)
    {
        if ( $this->checkMappingName($event) ) {
            $object = $event->getObject();
            $mapping = $event->getMapping();
            $imagePath = $mapping->getUploadDestination() . DIRECTORY_SEPARATOR . $object->getImageName();
            ResizeProductImage::resizeAndSaveImage($imagePath);
        }
    }

    public function onVichUploaderPreRemove(Event $event)
    {
        if ( $this->checkMappingName($event) ) {
            $object = $event->getObject();
            $mapping = $event->getMapping();
            $resizedImagePath = ResizeProductImage::getResizedImagePath($mapping->getUploadDestination() . DIRECTORY_SEPARATOR . $object->getImageName());
            unlink($resizedImagePath);
        }
    }

    protected function checkMappingName(Event $event) : bool
    {
        return $event->getMapping()->getMappingName() === self::MAPPING_NAME;
    }
}