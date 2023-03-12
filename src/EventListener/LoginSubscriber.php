<?php 

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginSubscriber extends AbstractController implements EventSubscriberInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) 
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
            LoginFailureEvent::class => 'onLoginFailure'
        ];
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $this->addFlash(
            'success',
            'Vous êtes désormais connecté.'
        );

        $response = new RedirectResponse(
            $this->urlGenerator->generate('app_snowtrick_index'),
            RedirectResponse::HTTP_SEE_OTHER
        );
        $event->setResponse($response);
    }

    public function onLoginFailure(LoginFailureEvent $event): void
    {
        $this->addFlash(
            'danger',
            'Vos identifiants sont erronés ou votre compte n\'est peut être pas activé, veuillez vérifier vos mails ou réessayer de vous connecter.'
        );

        $response = new RedirectResponse(
            $this->urlGenerator->generate('app_login'),
            RedirectResponse::HTTP_SEE_OTHER
        );
        $event->setResponse($response);
    }
}
