<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{

    #[Route('/', name: 'app')]
    public function newImage()
    {
       return $this->render('index.html.twig');
    }

    #[Route('/main', name: 'app_main')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);
    }

    #[Route('/photo', name: 'photo')]
    public function photo(Request $request, ImagesRepository $repo)
    {

        $files= $repo->findRandImage();

        $filename = $this->getParameter('kernel.project_dir') . '\public\images\\' . $files[0]->getImageName();

        return new BinaryFileResponse($filename);

       
    }

    #[Route('/photo/{tag}', name: 'photo_tag')]
    public function photoTag(string $tag,Request $request, ImagesRepository $repo)
    {


        $files= $repo->findRandImageWithTag($tag);

        if(!$files){
            return new BinaryFileResponse(
                $this->getParameter('kernel.project_dir') . '\public\images\default.jpg'
            );
        }

        $filename = $this->getParameter('kernel.project_dir') . '\public\images\\' . $files[0]->getImageName();

        return new BinaryFileResponse($filename);

       
    }
}
