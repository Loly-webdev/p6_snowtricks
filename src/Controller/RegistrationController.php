<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Mailer;
use App\Form\RegistrationType;
use App\Service\UploaderHelper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * @var TokenGeneratorInterface
     */
    private TokenGeneratorInterface $token;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, TokenGeneratorInterface $token)
    {
        $this->manager        = $manager;
        $this->encoder        = $encoder;
        $this->token = $token;
    }

    /**
     * @Route("/inscription", name="register")
     * @param Request        $request
     * @param UploaderHelper $uploaderHelper
     * @param Mailer         $mailer
     *
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(Request $request, UploaderHelper $uploaderHelper, Mailer $mailer): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['profile_picture']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadPicture($uploadedFile, 'profilePictures');
                $user->setProfilePicture($newFilename);
            }
            else {
                $user->setProfilePicture('profile-picture-default.png');
            }

            $user->setRoles(['ROLE_USER'])
                 ->setPassword($this->encoder->encodePassword($user, $user->getPassword()))
                 ->setActivationToken($this->token->generateToken());
            $this->manager->persist($user);
            $this->manager->flush();

            $mailer->sendMessage('noreply@snowtricks.com',
                                 $user->getEmail(),
                                 $user->getUsername(),
                                 'Activer votre compte',
                                 'email/activation.html.twig', [
                                     'user'  => $user,
                                     'token' => $user->getActivationToken()
                                 ]);

            $this->addFlash('success', 'Votre compte a bien été créé. Un email vient de vous être envoyé pour activer votre compte.');
        }
        return $this->render('security/register.html.twig', [
            'controller_name' => 'AccountController',
            'form'            => $form->createView()
        ]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     * @param                $token
     * @param UserRepository $userRepository
     *
     * @return RedirectResponse
     */
    public function activation($token, UserRepository $userRepository): RedirectResponse
    {
        $user = $userRepository->findOneBy(['activation_token' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        $user->setActivationToken(null)
             ->setIsVerified(1);

        $this->manager->persist($user);
        $this->manager->flush();

        $this->addFlash('success', 'Votre compte a bien été activé.');
        return $this->redirectToRoute('login');
    }
}
