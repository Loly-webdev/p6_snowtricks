<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Class Mailer
 * @package App\Service
 */
class Mailer
{
    private MailerInterface $mailerInterface;

    /**
     * Mailer constructor.
     *
     * @param MailerInterface $mailerInterface
     */
    public function __construct(MailerInterface $mailerInterface)
    {
        $this->mailerInterface = $mailerInterface;
    }

    /**
     * @param string $from
     * @param string $toEmail
     * @param string $toUsername
     * @param string $subject
     * @param string $template
     * @param array  $parameters
     *
     * @throws TransportExceptionInterface
     */
    public function sendMessage(
        string $from,
        string $toEmail,
        string $toUsername,
        string $subject,
        string $template,
        array $parameters
    ): void {
        $email = (new TemplatedEmail())
            ->from(new Address($from))
            ->to(new Address($toEmail, $toUsername))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context(
                $parameters
            );
        $this->mailerInterface->send($email);
    }
}
