<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ImagesRepository;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index()
    {
        return $this->render('index.html.twig');
    }

    #[Route('/doc', name: 'doc')]
    public function doc()
    {
        return $this->render('doc.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerService $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $subject = 'Demande de contact sur votre site de '.$contactFormData['email'];
            $content = $contactFormData['nom']
                .' vous a envoyé le message suivant: '
                .$contactFormData['message'];
            $mailer->sendEmail(subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/photo', name: 'photo')]
    public function photo(ImagesRepository $repo)
    {
        $file = $repo->findRandImage();

        if ($file) {
            $filename = $this->getParameter('kernel.project_dir').'/public/images/'.$file->getImageName();

            if (file_exists($filename)) {
                return new BinaryFileResponse($filename);
            }
        } else {
            return new JsonResponse(null, 404);
        }
    }

    #[Route('/photo/{tag}', name: 'photo_tag')]
    public function photoTag(string $tag, ImagesRepository $repo)
    {
        $file = $repo->findRandImageWithTag($tag);

        if ($file) {
            $filename = $this->getParameter('kernel.project_dir').'/public/images/'.$file->getImageName();

            if (file_exists($filename)) {
                return new BinaryFileResponse($filename);
            } else {
                return new JsonResponse(null, 404);
            }
        } else {
            return new BinaryFileResponse(
                $this->getParameter('kernel.project_dir').'/public/images/default.jpg'
            );
        }
    }

    #[Route('/photo/{tag}/{id}', name: 'photo_tag_id')]
    public function photoTagId(string $tag, int $id,Request $request, ImagesRepository $repo)
    {


        $files= $repo->findImageWithTagId($tag,$id);

        if(!$files){
            return new BinaryFileResponse(
                $this->getParameter('kernel.project_dir') . '\public\images\default.jpg'
            );
        }

        // $filename = $this->getParameter('kernel.project_dir') . '\public\images\\' . $files[0]->getImageName();

        // return new BinaryFileResponse($filename);
        return $this->redirect('https://127.0.0.1:8000/images/' . $files[0]->getImageName());
    }
}
