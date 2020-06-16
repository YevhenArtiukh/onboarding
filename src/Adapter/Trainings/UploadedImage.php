<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-24
 * Time: 16:45
 */

namespace App\Adapter\Trainings;

use App\Entity\Trainings\UseCase\CreateTraining\UploadedImage as UploadedImageInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedImage implements UploadedImageInterface
{
    private $uploadedFile;
    private $targetDir;

    public function __construct(
        UploadedFile $file,
        string $targetDir
    )
    {
        $this->uploadedFile = $file;
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