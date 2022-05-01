<?php

namespace App\Controller\Admin;

use App\Form\SettingFormType;
use App\Repository\SettingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin-setting", name="admin-setting")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request, SettingRepository $settingRepository): Response
    {
        $setting = $settingRepository->findOneById();
        $form = $this->createForm(SettingFormType::class, $setting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($setting);
            $this->entityManager->flush();
            return $this->redirect($request->getUri());
        }

        return $this->render('admin/setting.html.twig', [
            'setting_form' => $form->createView(),
        ]);
    }
}