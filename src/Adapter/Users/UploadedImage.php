<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 17:19
 */

namespace App\Adapter\Users;

use App\Entity\Users\UseCase\FirstLoginUser\UploadedImage as UploadedImageInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedImage implements UploadedImageInterface
{
    private $uploadedFile;
    private $targetDir;

    public function __construct(
        UploadedFile $uploadedImage,
        string $targetDir
    )
    {
        $this->uploadedFile = $uploadedImage;
        $this->targetDir = $targetDir;
    }

    public function move()
    {
        if(!$this->uploadedFile) {
            return '';
        }

        $dir = $this->targetDir.DIRECTORY_SEPARATOR;
        $fileName = uniqid().'-'.$this->uploadedFile->getClientOriginalName();
        $this->uploadedFile->move($dir, $fileName);

        return $fileName;
    }
}