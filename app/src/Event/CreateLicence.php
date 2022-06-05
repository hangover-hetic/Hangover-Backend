<?php

namespace App\Event;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Licence;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

final class CreateNewLicence implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setNewLicence', EventPriorities::POST_WRITE],
        ];
    }

    public function setNewLicence(ControllerArgumentsEvent $test, ViewEvent $event, ManagerRegistry $doctrine): void
    {
        $namedArguments = $test->getRequest()->attributes->all();
        $entityManager = $doctrine->getManager();
        $licence = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        dd($namedArguments);

        if(!$licence instanceof Licence || Request::METHOD_POST !== $method) {
            return;
        }

        $newLicence = new Licence();
        $newLicence->setEndDate(new DateTime());
        $newLicence->setStartDate(new DateTime());
        $newLicence->setIsBuyed(1);

        $entityManager->persist($licence);
        $entityManager->flush();

    }
}

?>