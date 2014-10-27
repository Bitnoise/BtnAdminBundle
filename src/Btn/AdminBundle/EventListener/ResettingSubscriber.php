<?php

namespace Btn\AdminBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\Routing\RouterInterface;

class ResettingSubscriber implements EventSubscriberInterface
{
    /** @var \Symfony\Component\Routing\RouterInterface $router */
    protected $router;

    /**
     *
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     *
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onResetSuccess',
        );
    }

    /**
     *
     */
    public function onResetSuccess(FormEvent $event)
    {
        if (null === $this->router->getRouteCollection()->get('fos_user_profile_show')) {
            $url = $this->router->generate('btn_admin_usercontrol_profile');
            $response = new RedirectResponse($url);

            $event->setResponse($response);
        }
    }
}
