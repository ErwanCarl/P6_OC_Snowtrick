<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailerService;
use Doctrine\ORM\Mapping\Entity;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(['ROLE_USER']);

            $accountKey = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
            $user->setAccountKey($accountKey);

            $entityManager->persist($user);
            $entityManager->flush();

            $mailerService->sendRegistrationEmail($user);
            $this->addFlash(
                'success',
                'Votre compte a bien été crée, veuillez vérifier vos mails pour le valider.'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/accountvalidation/{accountKey}', name: 'app_account_validation')]
    public function verifyAccountEmail(string $accountKey, UserRepository $userRepository) : Response
    {
        $user = $userRepository->findOneByKey($accountKey);
        
        if(!$user) {
            $this->addFlash(
                'danger',
                'Le lien a expiré ou n\'est plus valide, veuillez tenter de vous connecter ou contactez l\'administrateur.'
            );
            return $this->redirectToRoute('app_not_found');
        }

        $user->setAccountKey(null);
        $user->setIsVerified(true);
        $userRepository->save($user, true);

        $this->addFlash(
            'success',
            'Votre compte a bien été validé, vous pouvez désormais vous connecter.'
        );
        return $this->redirectToRoute('app_login');
    }
}
