<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LogoFormType;
use App\Form\LostPasswordType;
use Doctrine\ORM\EntityManager;
use App\Service\FormInputHandler;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountSettingController extends AbstractController
{
    #[Route('/accountsettings', name: 'app_account_settings')]
    public function accountSettings(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $lostPasswordForm = $this->createForm(LostPasswordType::class, $user);
        $lostPasswordForm->handleRequest($request);

        $logoForm = $this->createForm(LogoFormType::class);
        
        if ($lostPasswordForm->isSubmitted() && $lostPasswordForm->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $lostPasswordForm->get('plainPassword')->getData()
                )
            );
            $userRepository->save($user, true);

            $this->addFlash(
                'success',
                'Votre nouveau mot de passe a bien été enregistré.'
            );

            return $this->redirectToRoute('app_account_settings');
        }

        return $this->render('accountsettings/account-settings.html.twig', [
            'user' => $user,
            'lostPasswordForm' => $lostPasswordForm->createView(),
            'logoForm' => $logoForm->createView()
        ]);
    }

    #[Route('/logosettings', name: 'app_logo_settings')]
    public function logoSettings(Request $request, LogoFormType $logoForm, UserRepository $userRepository): Response
    {
        $logoForm = $this->createForm(LogoFormType::class);
        $logoForm->handleRequest($request);

        if ($logoForm->isSubmitted() && $logoForm->isValid()) {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $user->setLogo($logoForm->get('logoChoice')->getData());

            $userRepository->save($user, true);

            $this->addFlash(
                'success',
                'Votre choix de logo a bien été enregistré.'
            );

            return $this->redirectToRoute('app_account_settings');
        }

        $this->addFlash(
            'danger',
            'L\'enregitrement de votre choix a échoué, veuillez retenter.'
        );

        return $this->redirectToRoute('app_account_settings');
    }
}
