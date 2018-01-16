<?php

namespace Codeages\PhalconBiz\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResponseSubscriber implements EventSubscriberInterface
{
    public function onView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!is_array($result)) {
            throw new \LogicException('The controller must return array or response instance.');
        }

        $response = $event->getDI()->get('response');
        $response->setStatusCode(200);
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($result));

        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            WebEvents::VIEW => 'onView',
        ];
    }
}
