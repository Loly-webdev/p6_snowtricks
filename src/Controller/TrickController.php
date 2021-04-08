<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Service\FileUploader;
use App\Service\Paginator;
use App\Service\UploaderHelper;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @param Request        $request
     * @param UploaderHelper $uploaderHelper
     *
     * @return Response
     */
    public function new(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $form['pictures']->getData();
            foreach ($pictures as $picture) {
                $uploadedFile = $picture->getFile();
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadPicture($uploadedFile, 'pictures');
                    $picture->setPath($newFilename);
                }
                $picture->setTrick($trick);
                $this->manager->persist($picture);
            }

            foreach ($trick->getVideos() as $video) {
                $video->setTrick($trick);
                $this->manager->persist($video);
            }

            $this->manager->persist($trick);
            $this->manager->flush();

            $this->addFlash('success', "La nouvelle figure  a bien été enregistrée.");

            return $this->redirectToRoute('trick_show', [
                'slug' => $trick->getSlug()
            ]);
        }
        return $this->render('trick/new.html.twig', [
            'controller_name' => 'TrickController',
            'form'            => $form->createView()
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

        return $this->render(
            'trick/show.html.twig',
            [
                'controller_name' => 'TrickController',
                'trick'           => $trick,
                'paginator'       => $paginator,
                'user'            => $this->getUser(),
                'form'            => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit", methods={"GET","POST"})
     * @param Request          $request
     * @param Trick            $trick
     * @param SluggerInterface $slugger
     *
     * @return Response
     */
    public function edit(Request $request, Trick $trick, SluggerInterface $slugger): Response
    {
        $originalPictures = new ArrayCollection();
        $originalVideos   = new ArrayCollection();
        $trick->setUpdatedAt(new Datetime());

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename  = $safeFilename.'-'.uniqid('', true).'.'.$uploadedFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $uploadedFile->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $uploadedFile->setFile($newFilename);
            }
            $uploadedFile->setTrick($trick);
            $this->manager->persist($uploadedFile);

            foreach ($originalPictures as $picture) {
                if (false === $trick->getPictures()->contains($picture)) {
                    $picture->getTrick()->removeElement($trick);
                    $this->manager->persist($picture);
                }
            }

            foreach ($originalVideos as $video) {
                if (false === $trick->getVideos()->contains($video)) {
                    $video->getTrick()->removeElement($trick);
                    $this->manager->persist($video);
                }
            }

            $this->manager->persist($trick);
            $this->manager->flush();

            $this->addFlash(
                'success',
                'La figure a bien été modifié.'
            );

            return $this->redirectToRoute(
                'trick_show',
                [
                    'slug' => $trick->getSlug(),
                ]
            );
        }

        return $this->render(
            'trick/edit.html.twig',
            [
                'controller_name' => 'TrickController',
                'trick'           => $trick,
                'form'            => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete", methods={"DELETE"})
     * @param Request $request
     * @param Trick   $trick
     *
     * @return Response
     */
    public
    function delete(
        Request $request,
        Trick $trick
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $this->manager->remove($trick);
            $this->manager->flush();

            $this->addFlash('success', "La figure {$trick->getName()} a bien été supprimé.");
        }

        return $this->redirectToRoute('home');
    }
}
