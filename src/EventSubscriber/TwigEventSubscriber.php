<?php

namespace App\EventSubscriber;

use App\Repository\SettingRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $settingRepository;

    public function __construct(Environment $twig, SettingRepository $settingRepository)
    {
        $this->twig = $twig;
        $this->settingRepository = $settingRepository;
    }

    public function onControllerEvent(ControllerEvent $event)
    {
        $this->twig->addGlobal('settings', $this->settingRepository->findOneById());
    }

    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
