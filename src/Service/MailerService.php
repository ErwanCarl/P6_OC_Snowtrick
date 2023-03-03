<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService 
{

    private $mailer;

    public function __construct(MailerInterface $mailerInterface)
    {
        $this->mailer = $mailerInterface;
    }

    public function sendRegistrationEmail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from('erwan.carlini@orange.fr')
            ->to($user->getMail())
            ->subject('Validation de compte utilisateur')
            ->htmlTemplate('registration/confirmation_email.html.twig')
            ->context([ 
                'user' => $user
            ]);

        $this->mailer->send($email);
    }
}
