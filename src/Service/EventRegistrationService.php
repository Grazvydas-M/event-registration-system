<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Registration;
use Doctrine\ORM\EntityManagerInterface;
readonly class EventRegistrationService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function registerForEvent(Registration $registration, Event $event): bool
    {
        $event->setAvailableSpots($event->getAvailableSpots() - 1);
        $registration->setEvent($event);
        $this->entityManager->persist($registration);
        $this->entityManager->flush();

        return true;
    }

    public function checkIfAvailableSlots($event): bool
    {
        return $event->getAvailableSpots() > 0;
    }
}