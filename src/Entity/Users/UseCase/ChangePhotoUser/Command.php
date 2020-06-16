<?php


namespace App\Entity\Users\UseCase\ChangePhotoUser;


use App\Adapter\Users\UploadedImage;
use App\Entity\Users\User;

class Command
{
    private $user;
    private $photo;
    private $responder;


    public function __construct(
        User $user,
        UploadedImage $photo
    )
    {
        $this->user = $user;
        $this->photo = $photo;
        $this->responder = new NullResponder();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return UploadedImage
     */
    public function getPhoto(): UploadedImage
    {
        return $this->photo;
    }

    /**
     * @return Responder
     */
    public function getResponder(): Responder
    {
        return $this->responder;
    }

    /**
     * @param Responder $responder
     */
    public function setResponder(Responder $responder): void
    {
        $this->responder = $responder;
    }





}