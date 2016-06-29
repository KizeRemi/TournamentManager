<?php

namespace CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\ParameterBag;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $contentType = $request->headers->get('Content-Type');
        $type = explode(";", $contentType);

        if ("text/plain" === $type[0]) {

            $content = $request->getContent();

            $data = json_decode($content, true);

            $request->request = new ParameterBag($data);
        }
    }
}
