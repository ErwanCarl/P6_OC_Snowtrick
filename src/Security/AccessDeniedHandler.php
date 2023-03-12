<?php 

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler extends AbstractController implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $this->addFlash(
            'danger',
            'L\'accès à cette page vous est refusé, vous n\'avez pas les droits nécessaires.'
        );

        return $this->redirectToRoute('app_forbidden', [], Response::HTTP_SEE_OTHER);
    }
}
