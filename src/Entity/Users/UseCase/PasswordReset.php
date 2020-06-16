<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 9:50
 */

namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Emails\Emails;
use App\Entity\Users\UseCase\PasswordReset\Command;
use App\Entity\Users\UseCase\PasswordReset\GenerateEmail;
use App\Entity\Users\Users;
use LogicException;

class PasswordReset
{
    private $users;
    private $emails;
    private $generateEmail;
    private $transaction;

    public function __construct(
        Users $users,
        Emails $emails,
        GenerateEmail $generateEmail,
        Transaction $transaction
    )
    {
        $this->users = $users;
        $this->emails = $emails;
        $this->generateEmail = $generateEmail;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingUser = $this->users->findOneByEmail($command->getEmail());

        if(!$existingUser)
            return;

        $emailFunction = 'password-reset';

        $email = $this->emails->findOneByFunction($emailFunction);

        if($email) {
            $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');

            $existingUser->passwordReset($token);

            $this->generateEmail->notify($email,$existingUser, $token);
        }


        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}