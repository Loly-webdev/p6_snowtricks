<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\Paginator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trick")
 */
class TrickController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * TrickController constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/trick/new", name="trick_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($trick);
            $this->manager->flush();

            $this->addFlash('success', "La nouvelle figure  a bien été enregistrée.");

            return $this->redirectToRoute('trick_show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}/{page<\d+>?1}", name="trick_show")
     * @param Trick     $trick
     * @param Request   $request
     * @param int       $page
     * @param Paginator $paginator
     *
     * @return Response
     */
    public function show(Trick $trick, Request $request, int $page, Paginator $paginator): Response
    {
        $comment = new Comment();
        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $this->manager->persist($comment);
            $this->manager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire a bien été enregistré !'
            );
        }
        $paginator
            ->setEntity(Comment::class)
            ->setOrder(['created_at' => 'DESC'])
            ->setAttribute(['trick' => $trick])
            ->setCurrentPage($page)
            ->setLimit(4);

        return $this->render('trick/show.html.twig', [
            'controller_name' => 'TrickController',
            'trick'           => $trick,
            'paginator'       => $paginator,
            'user'            => $this->getUser(),
            'form'            => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Trick   $trick
     *
     * @return Response
     */
    public function edit(Request $request, Trick $trick): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new DateTime());
            $this->manager->persist($trick);
            $this->manager->flush();

            $this->addFlash('success', "La figure a bien été modifié.");
            return $this->redirectToRoute('trick_show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete", methods={"DELETE"})
     * @param Request $request
     * @param Trick   $trick
     *
     * @return Response
     */
    public function delete(Request $request, Trick $trick): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $this->manager->remove($trick);
            $this->manager->flush();

            $this->addFlash('success', "La figure {$trick->getName()} a bien été supprimé.");
        }

        return $this->redirectToRoute('home');
    }
}
