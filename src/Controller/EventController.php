<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Form\RegistrationType;
use App\Repository\EventRepository;
use App\Service\EventRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    public function __construct(
        private readonly EventRegistrationService $eventRegistrationService,
    ) {
    }

    #[Route('/events', name: 'events')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/events/{id}/register', name: 'event_register')]
    public function registration(
        Request $request,
        Event $event,
    ): Response {
        $isEventAvailable = $this->eventRegistrationService->checkIfAvailableSlots($event);

        if (!$isEventAvailable) {
            $this->addFlash('error', 'Sorry, this event has no available spots.');

            return $this->redirectToRoute('events');
        }

        $registration = new Registration();
        $form = $this->createForm(RegistrationType::class, $registration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventRegistrationService->registerForEvent($registration, $event);
            $this->addFlash('success', 'You have been registered to ' . $event->getName() . ' event on ' . $event->getDate()->format('Y-m-d H:i'));

            return $this->redirectToRoute('events');
        }

        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
        ]);
    }
}
