<?php

namespace App\Controller;

use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthenticatorController
 * @package App\Controller
 */
class AuthenticatorController extends AbstractController
{
    /**
     * @Route("/connexion", name="login")
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render(
            'security/login.html.twig',
            [
                'controller_name' => 'AccountController',
                'lastUsername'    => $authenticationUtils->getLastUsername(),
                'error'           => $authenticationUtils->getLastAuthenticationError(),
            ]
        );
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout(): void
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }
}
