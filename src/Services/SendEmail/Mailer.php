<?php

declare(strict_types=1);

namespace App\Services\SendEmail;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class Mailer
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string          $from
    )
    {

    }

    public function envoyer(
        string $pathFile,
        string $destinataire = 'you@example.com',
        string $object = 'test'
    ): void
    {
        $email = (new Email)
            ->from($this->from)
            ->to($destinataire)
            ->subject($object)
            ->attachFromPath($pathFile);

        $this->mailer->send($email);
    }
}