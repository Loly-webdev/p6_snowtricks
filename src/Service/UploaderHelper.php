<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploaderHelper
 * @package App\Service
 */
class UploaderHelper
{
    /**
     * @var string
     */
    private string $uploadsPath;

    /**
     * UploaderHelper constructor.
     *
     * @param string $uploadsPath
     */
    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string       $folder
     *
     * @return string
     */
    public function uploadPicture(UploadedFile $uploadedFile, string $folder): string
    {
        $load             = $this->uploadsPath.'/'.$folder;
        $originalFilename = basename($uploadedFile->getClientOriginalName());
        $newFilename      = $originalFilename.'-'.uniqid('', true).'.'.$uploadedFile->guessExtension();

        $uploadedFile->move(
            $load,
            $newFilename
        );

        return $newFilename;
    }

    /**
     * @param string $oldFileName
     */
    public function removeFile(string $oldFileName): void
    {
        try {
            unlink($this->uploadsPath.'/'. $oldFileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
    }

}
