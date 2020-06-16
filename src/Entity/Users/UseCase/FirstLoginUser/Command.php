<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-26
 * Time: 17:17
 */

namespace App\Entity\Users\UseCase\FirstLoginUser;

use App\Entity\Roles\Role;
use App\Adapter\Users\UploadedImage;

class Command
{
    private $id;
    private $password;
    private $role;
    private $photo;
    private $responder;

    public function __construct(
        int $id,
        string $password,
        Role $role,
        ?UploadedImage $uploadedImage
    )
    {
        $this->id = $id;
        $this->password = $password;
        $this->role = $role;
        $this->photo = $uploadedImage;
        $this->responder = new NullResponder();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return UploadedImage|null
     */
    public function getPhoto(): ?UploadedImage
    {
        return $this->photo;
    }

    public function getResponder(): Responder
    {
        return $this->responder;
    }

    public function setResponder(Responder $responder): self
    {
        $this->responder = $responder;

        return $this;
    }
}