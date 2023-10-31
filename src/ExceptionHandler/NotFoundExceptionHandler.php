<?php
namespace App\ExceptionHandler;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class NotFoundExceptionHandler implements EventSubscriberInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function handleNotFound()
    {
        $url = $this->router->generate('app_home');
        return new RedirectResponse($url);
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof NotFoundHttpException) {
            $response = $this->handleNotFound();
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        // Повідомте Symfony, що цей обробник підписується на подію kernel.exception.
        // Коли виникає виняток, обробник буде викликано.
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
