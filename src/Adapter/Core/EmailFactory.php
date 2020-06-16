<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 10:48
 */

namespace App\Adapter\Core;

final class EmailFactory
{
    private $from;

    public function __construct(
        $from
    )
    {
        $this->from = $from;
    }

    public function create(
        string $subject,
        string $template,
        array $users
    )
    {
        $swiftMessage = new \Swift_Message();
        $swiftMessage->setSubject($subject);

        $swiftMessage
            ->setBody(nl2br($template),'text/html')
            ->setFrom($this->from, 'myStart')
            ->setTo($users);

        return $swiftMessage;
    }
}