<?php

namespace App\EventListener;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Organisator;
use App\Security\Roles;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mime\Email;

final class CreateOrganisatorListener implements EventSubscriberInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['addOrganisatorRole', EventPriorities::POST_WRITE],
        ];
    }

    public function addOrganisatorRole(ViewEvent $event): void
    {
        $organisator = $event->getControllerResult();

        if (!$organisator instanceof Organisator) {
            return;
        }
        $user = $organisator->getRelatedUser();

        if(!in_array(Roles::$ORGANISATOR, $user->getRoles())) {
            $user->addRoles(Roles::$ORGANISATOR);
            $this->entityManager->flush();
        }
    }
}
