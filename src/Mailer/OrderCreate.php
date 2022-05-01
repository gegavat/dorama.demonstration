<?php

namespace App\Mailer;

use App\Entity\Order;
use App\Entity\Setting;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class OrderCreate
{
    public static function sendMail(Order $order, Setting $settings, MailerInterface $mailer, int $orderTotalSum)
    {
        if ($emailStr = $settings->getEmails()) {
            $emailArr = array_map(function ($val) {
                return trim($val);
            }, explode(',', $emailStr));
            $email = (new TemplatedEmail())
                ->to(...$emailArr)
                ->subject('На сайте Dorama создан новый заказ')
                ->htmlTemplate('email/order.html.twig')
                ->context([
                    'order' => $order,
                    'orderTotalSum' => $orderTotalSum
                ]);

            $mailer->send($email);
        }
    }
}