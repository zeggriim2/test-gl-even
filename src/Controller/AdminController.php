<?php

namespace App\Controller;

use App\Form\AdminType;
use App\Message\CsvMessage;
use App\Services\Deserialize\DeserializeLineCsvEnter;
use App\Services\Model\LineCsvEnter;
use App\Services\Model\LineCsvExit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Mime\Email;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        Request                 $request,
        DeserializeLineCsvEnter $deserializeLineCsvEnter,
        MessageBusInterface     $messageBus
    ): Response
    {
        $form = $this->createForm(AdminType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $form->getData()['file'];
            $linesEnter = $deserializeLineCsvEnter->deserialize($file->getContent());
            
            $messageBus->dispatch(new CsvMessage($linesEnter));

            return $this->redirectToRoute('app_admin_res');
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/res', name: 'app_admin_res')]
    public function result(): response
    {
        return $this->render('admin/res.html.twig');
    }
}
