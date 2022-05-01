<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Form\OrderFormType;
use App\Mailer\OrderCreate;
use App\Repository\OrderRepository;
use App\Repository\SettingRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index(
        Request $request,
        ManagerRegistry $doctrine,
        OrderRepository $orderRepository,
        SettingRepository $settingRepository,
        MailerInterface $mailer
    ): Response
    {
        if ( !$urlData = $request->query->get('data') ) {
            return new Response('Параметры запроса не заданы');
        }

        $urlData = json_decode($urlData);
        $order = new Order();
        $form = $this->createForm(OrderFormType::class, $order);

        $data = $orderRepository->getFullCardData($urlData);
        $orderTotalSum = $orderRepository->getOrderTotalSum($data);

        if ( $request->isMethod('POST') ) {
            $form->handleRequest($request);
            // настройка заказа (в дальнейшем переделать)
            $order->setStatus(Order::STATUS_NEW);
            $order->setCreatedAt(new \DateTimeImmutable("now"));
            $order->setUpdatedAt(new \DateTimeImmutable("now"));
            if ($form->isSubmitted() && $form->isValid()) {
                $order = $form->getData();
                // настройка позиций заказа для дальнейшего сохранения
                foreach ( $data as $item ) {
                    $orderItem = new OrderItem();
                    $orderItem->setProduct($item->product);
                    $orderItem->setQuantity($item->quantity);
                    $orderItem->setOrder($order);
                    foreach ( $item->configuratorItems as $confItem ) {
                        $orderItem->getConfiguratorItems()->add($confItem);
                    }
                    $order->getOrderItems()->add($orderItem);
                }
                $entityManager = $doctrine->getManager();
                $entityManager->persist($order);
                $entityManager->flush();

                OrderCreate::sendMail($order, $settingRepository->findOneById(), $mailer, $orderTotalSum);
                return new Response('<h2 class="mt-3" style="text-align:center">Спасибо за заказ. Уже занимаемся его выполнением</h2>');
            }
        }


        return $this->renderForm('order/index.html.twig', [
            'form' => $form,
            'data' => $data
        ]);

    }
}
