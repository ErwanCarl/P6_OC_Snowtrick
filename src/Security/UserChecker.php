<?php 

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class UserChecker extends AbstractController implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            throw new CustomUserMessageAccountStatusException('Problème d\'identifiants incorrects.');
        }

        if ($user->isVerified() == false) {
            throw new CustomUserMessageAccountStatusException('Votre compte n\'est pas encore validé, veuillez vérifier vos mails pour l\'activer.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
