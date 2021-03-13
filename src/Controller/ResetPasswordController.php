<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Mailer;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Form\ForgottenPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends AbstractController
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
    private TokenGeneratorInterface $tokenGenerator;

    /**
     * ResetPasswordController constructor.
     *
     * @param EntityManagerInterface       $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenGeneratorInterface      $tokenGenerator
     */
    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, TokenGeneratorInterface $tokenGenerator)
    {
        $this->manager        = $manager;
        $this->encoder        = $encoder;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @Route("/mot-de-passe-oublié", name="forgotten_password")
     * @param Request        $request
     * @param UserRepository $userRepository
     * @param Mailer         $mailer
     *
     * @return RedirectResponse|Response
     * @throws TransportExceptionInterface
     */
    public function forgottenPassword(Request $request, UserRepository $userRepository, Mailer $mailer)
    {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user  = $userRepository->findOneBy($data['email']);

            if (!$user) {
                $this->addFlash('error', 'Cette adresse e-mail est inconnue');
                return $this->redirectToRoute('login');
            }

            $token = $this->tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $this->manager->persist($user);
                $this->manager->flush();
            } catch (Exception $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('login');
            }

            $mailer->sendMessage('noreply@snowtricks.com', $user->getEmail(), $user->getUsername(), 'Mot de passe oublié', 'email/reset-password.html.twig', [
                'user'  => $user,
                'token' => $user->getResetToken()
            ]);

            $this->addFlash('success', 'Un email de réinitialisation du mot de passe vient de vous être envoyé.');

            return $this->redirectToRoute('login');
        }

        return $this->render('security/forgotten-password.html.twig', [
            'controller_name' => 'AccountController',
            'form'            => $form->createView(),
        ]);
    }

    /**
     * @Route("/réinitialisation/{id}/{token}", name="reset_password")
     * @param Request                 $request
     * @param User                    $user
     * @param TokenGeneratorInterface $token
     *
     * @return RedirectResponse|Response
     */
    public function resetPassword(Request $request, User $user, TokenGeneratorInterface $token)
    {
        if ($user->getResetToken() === null || $token !== $user->getResetToken()) {

            $this->addFlash('error', 'Token Inconnu');
            return $this->redirectToRoute('login');
        }
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
            $user->setResetToken(null);
            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');

            return $this->redirectToRoute('login');
        }
        return $this->render('security/reset-password.html.twig', [
            'controller_name' => 'AccountController',
            'token'           => $token,
            'form'            => $form->createView()
        ]);
    }
}
