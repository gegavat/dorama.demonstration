<?php

namespace App\Service;


class ResizeProductImage
{

    public static function resizeAndSaveImage(string $imagePath)
    {
        $uploadedImage = imagecreatefromjpeg($imagePath);
        $tempImage = imagecreatetruecolor($_ENV['RESIZE_IMAGE_WIDTH'], $_ENV['RESIZE_IMAGE_HEIGHT']);
        imagecopyresampled(
            $tempImage, $uploadedImage,
            0, 0, 0, 0,
            $_ENV['RESIZE_IMAGE_WIDTH'], $_ENV['RESIZE_IMAGE_HEIGHT'],
            imagesx($uploadedImage), imagesy($uploadedImage)
        );

        imagejpeg($tempImage, self::getResizedImagePath($imagePath));
    }

    public static function getResizedImagePath($imagePath)
    {
        $pathParts = pathinfo($imagePath);
        return $pathParts['dirname'] . '/' . $pathParts['filename'] . $_ENV['RESIZE_IMAGE_TAIL'] . '.' . $pathParts['extension'];
    }

}
