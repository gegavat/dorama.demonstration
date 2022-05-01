<?php

namespace App\Controller;

use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Mailer\MailerInterface;

class TestController extends AbstractController
{

    /**
     * @Route("/test-email", name="test-email")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(MailerInterface $mailer, SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findOneById();
        if ( $emailStr = $settings->getEmails() ) {
            $emailArr = array_map(function($val) {
                return trim($val);
            }, explode(',', $emailStr));
            $email = (new Email())
                ->to(...$emailArr)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!');

            $mailer->send($email);

            return new Response('123');
        } else {
            return new Response('Не указаны email-адреса');
        }
    }

}