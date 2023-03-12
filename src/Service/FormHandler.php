<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormHandler extends AbstractController
{
    public function logoCheck(?string $logo) : bool 
    {
        $logoArray = ['user.png','user-2.png','bonsai.png','doc.png','drawing.png','epee.png','flower.png','globe.png','heart.png','horla.png'];

        if ($logo == null) {
            $this->addFlash(
                'danger',
                'Vous devez choisir un logo.'
            );
            return false;
        } elseif (!in_array($logo, $logoArray)) {
            $this->addFlash(
                'danger',
                'L\'enregistrement de votre choix a échoué, veuillez retenter.'
            );
            return false;
        } else {
            return true;
        }
    }
}
