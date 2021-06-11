<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Repository\CommentRepository;
use App\Service\Paginator;
use App\Service\UploaderHelper;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

            $this->addFlash(
                'success',
                "La nouvelle figure  a bien été enregistrée."
            );

            return $this->redirectToRoute('trick_show', [
                'slug' => $trick->getSlug()
            ]);
        }
        return $this->render('trick/new.html.twig', [
            'controller_name' => 'TrickController',
            'trick'           => $trick,
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

            $comment = $form->getData();
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
            $this->manager->flush();
            $this->addFlash('success', 'Trick modifié avec succès');
            return $this->redirectToRoute('trick_edit', [
                'id' => $trick->getId(),
            ]);
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'videos' => $trick->getVideos(),
            'pictures' => $trick->getPictures()
        ]);
    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete")
     * @IsGranted("ROLE_USER")
     * @param Trick $trick
     *
     * @return Response
     */
    public function delete(Trick $trick): Response
    {
        $filesystem = new Filesystem();

        foreach ($trick->getPictures() as $picture) {
            $filesystem->remove('uploads/pictures/' .$picture->getPath());
        }

        $this->manager->remove($trick);
        $this->manager->flush();

        $this->addFlash('success', "La figure {$trick->getName()} a bien été supprimé.");
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{category}/{id}/{comment<\d+>?5}", name="load_more_comment")
     */
    public function loadMoreComment(CommentRepository $commentRepository, $comment = 5, Trick $trick): Response
    {
        return $this->render('trick/loadMoreComments.html.twig', [
                'comments' => $commentRepository->findAllByTrick($trick->getId(), $comment)
            ]
        );
    }

    /**
     * @Route("/trick/modifier-trick/modifier-photo/{id}", name="trick_add_picture")
     * @param Trick          $trick
     * @param Request        $request
     * @param UploaderHelper $fileUploader
     *
     * @return Response
     */
    public function editDefaultPicture(Trick $trick, Request $request, UploaderHelper $fileUploader): Response
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();

            if ($trick->getDefaultPicture() !== null) {
                if ($trick->getDefaultPicture() === 'NULL') {
                    $fileUploader->removeFile($trick->getNameDefaultPicture());
                }
                $trick->setModifiedAt(new \DateTime());
                $defaultPicture = $trick->getDefaultPicture();
                $fileName = $fileUploader->uploadPicture($defaultPicture, 'picture');
                $trick->setNameDefaultPicture($fileName);
            }

            $this->manager->flush();

            $this->addFlash('success', 'Photo à la une changée avec succès');
            return $this->redirectToRoute('trick_edit', [
                'id' => $trick->getId()
            ]);
        }

        return $this->render('trick/edition/addPictureTrick.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/modifier-trick/photo/{id}", name="trick_edit_picture")
     * @param Picture        $pictureTrick
     * @param Request        $request
     * @param UploaderHelper $fileUploader
     *
     * @return Response
     */
    public function editPicture(Picture $pictureTrick, Request $request, UploaderHelper $fileUploader): Response
    {
        $form = $this->createForm(TrickType::class, $pictureTrick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileUploader->removeFile($pictureTrick->getPath());
            $pictureTrick = $form->getData();
            $file = $pictureTrick->getFile();
            $fileName = $fileUploader->uploadPicture($file, 'picture');
            $pictureTrick->setName($fileName);

            $this->manager->flush();
            $this->addFlash('success', 'Photo changée avec succès');
            return $this->redirectToRoute('trick_edit', [
                'id' => $pictureTrick->getId()
            ]);
        }

        return $this->render('trick/edition/editPictureTrick.html.twig', [
            'pictureTrick' => $pictureTrick,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/modifier-trick/video/{id}", name="trick_edit_video")
     * @param Video   $videoTrick
     * @param Request $request
     *
     * @return Response
     */
    public function editVideo(Video $videoTrick, Request $request): Response
    {
        $form = $this->createForm(VideoType::class, $videoTrick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videoTrick = $form->getData();
            $this->manager->flush();
            $this->addFlash('success', 'Vidéo changée avec succès');
            return $this->redirectToRoute('trick_edit', [
                'id' => $videoTrick->getId()
            ]);
        }

        return $this->render('trick/edition/editVideoTrick.html.twig', [
            'videoTrick' => $videoTrick,
            'form' => $form->createView()
        ]);
    }
}
