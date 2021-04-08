<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader extends AbstractController
{
    /**
     * @param                  $form
     * @param                  $uploadedFile
     * @param SluggerInterface $slugger
     *
     * @return string
     */
    public function upload($form, $uploadedFile, SluggerInterface $slugger): string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename  = $safeFilename.'-'.uniqid('', true).'.'.$uploadedFile->guessExtension();

        return $newFilename;
    }
}
