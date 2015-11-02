<?php

namespace Btn\AdminBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Btn\BaseBundle\Helper\RequestHelper;

class IndexStateStoreSubscriber implements EventSubscriberInterface
{
    /**
     *
     */
    public function onKernelResponse($event)
    {
        $request = $event->getRequest();

        if (!$this->isIndexRequest($request)) {
            return;
        }

        $route = $request->attributes->get('_route');
        $session = $request->getSession();
        $session->set('_btn.index_query_state.'.$route, $request->query->all());
    }

    /**
     *
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => 'onKernelResponse',
        );
    }

    /**
     *
     */
    private function isIndexRequest(Request $request)
    {
        if (!RequestHelper::isControlRequest($request)) {
            return;
        }

        if (!preg_match('~ControlController::indexAction$~', $request->attributes->get('_controller'))) {
            return;
        }

        return true;
    }
}
