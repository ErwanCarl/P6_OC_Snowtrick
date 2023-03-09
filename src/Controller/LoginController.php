<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LostPasswordType;
use App\Service\MailerService;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('connected', $user);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
    
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
    }

    #[Route('/lostpassword', name: 'app_lost_password')]
    public function lostpassword(Request $request, UserRepository $userRepository, MailerService $mailerService): Response
    {
        /** @var \App\Entity\User $isUser */
        $isUser = $this->getUser();
        $this->denyAccessUnlessGranted('connected', $isUser);
    
        $resetPasswordForm = $this->createForm(ResetPasswordType::class);
        $resetPasswordForm->handleRequest($request);

        if ($resetPasswordForm->isSubmitted() && $resetPasswordForm->isValid()) {
            $mail = $resetPasswordForm->get('resetPasswordMail')->getData();
            $user = $userRepository->findOneByMail($mail);
            if ($user == null) {
                $this->addFlash(
                    'success',
                    'Le mail de récupération de mot de passe vous a été envoyé à l\'adresse mail indiquée.'
                );
                return $this->redirectToRoute('app_login');
            }
            
            $accountKey = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
            $user->setAccountKey($accountKey);

            $userRepository->save($user, true);

            $mailerService->sendResetPasswordEmail($user);
            $this->addFlash(
                'success',
                'Le mail de récupération de mot de passe vous a été envoyé.'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('login/lostpassword.html.twig', [
            'resetPasswordForm' => $resetPasswordForm
        ]);
    }

    #[Route('/reset-password/{accountKey}', name: 'app_reset_password')]
    public function verifyAccountEmail(Request $request, string $accountKey, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher) : Response
    {
        $user = $userRepository->findOneByAccountKey($accountKey);

        if(!$user) {
            $this->addFlash(
                'danger',
                'Le lien a expiré ou n\'est plus valide, veuillez refaire une demande de récupération de mot de passe.'
            );
            return $this->redirectToRoute('app_login');
        }

        $lostPasswordForm = $this->createForm(LostPasswordType::class, $user);
        $lostPasswordForm->handleRequest($request);

        if ($lostPasswordForm->isSubmitted() && $lostPasswordForm->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $lostPasswordForm->get('plainPassword')->getData()
                )
            );
            $user->setAccountKey(null);
            $userRepository->save($user, true);

            $this->addFlash(
                'success',
                'Votre nouveau mot de passe a bien été enregistré.'
            );

            return $this->redirectToRoute('app_snowtrick_index');
        }

        return $this->render('login/reset-password.html.twig', [
            'user' => $user,
            'lostPasswordForm' => $lostPasswordForm->createView()
        ]);
    }
}
