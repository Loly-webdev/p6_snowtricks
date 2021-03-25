<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Security        $security
     * @param TrickRepository $trickRepository
     *
     * @return Response
     */
    public function index(Security $security, TrickRepository $trickRepository): Response
    {
        $user = $security->getUser();

        return $this->render('home/index.html.twig', [
            'username' => null === $user
                ? ''
                : $user->getUsername(),
            'tricks'   => $trickRepository->findAll()
        ]);
    }
}
