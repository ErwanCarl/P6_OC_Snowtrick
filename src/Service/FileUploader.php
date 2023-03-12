<?php

namespace App\Service;

use App\Entity\Snowtrick;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader extends AbstractController
{
    private $targetDirectory;
    private $slugger;

    public function __construct(mixed $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file) : string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            $this->addFlash(
                'danger',
                'L\'enregistrement de l\'image a échoué : '.$e->getMessage()
            );
        }

        return $fileName;
    }

    public function uploadImages(Snowtrick $snowtrick) : void
    {
        foreach($snowtrick->getPictures() as $picture)
        {
            if($picture->getFile() !== null)
            {
                $picture->setFileName($this->upload($picture->getFile()));
            } elseif ($picture->getFileName() === null && $picture->getFile() === null)
            {
                $snowtrick->removePicture($picture);
            }
        }
    }

    public function uploadVideos(Snowtrick $snowtrick) : void
    {
        foreach ($snowtrick->getVideos() as $video) {

            $check = parse_url($video->getUrl(), PHP_URL_HOST) ;
            parse_str(parse_url($video->getUrl(), PHP_URL_QUERY), $videoId);

            if ($check === "www.youtube.com" && array_key_exists('v', $videoId)) {

                $video->setVideoId($videoId['v']);

                $snowtrick->addVideo($video);
            } elseif ($video->getUrl() === null || $video->getVideoId() === null) {
                $snowtrick->removeVideo($video);
            }
        }
    }

    public function getTargetDirectory() : mixed
    {
        return $this->targetDirectory;
    }
}
