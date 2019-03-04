<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Service\PaginationService;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings/{page<\d+>?1}", name="admin_bookings_index")
     */
    public function index(BookingRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Booking::class)
                   ->setPage($page);

        return $this->render('admin/booking/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition d'une réservation
     *
     * @Route("/admin/bookings/{id}/edit", name="admin_bookings_edit")
     * 
     * @param Booking $booking
     * @return Response
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager) {
        $form = $this->createForm(AdminBookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de la réservation n° {$booking->getId()} ont bien été enregistrées !"
            );

            return $this->redirectToRoute('admin_bookings_index');
        }

        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     * 
     * @Route("/admin/bookings/{id}/delete", name="admin_bookings_delete")
     *
     * @param Booking $booking
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Booking $booking, ObjectManager $manager) {
        $manager->remove($booking);
        $manager->flush();
        
        $this->addFlash(
            'success',
            "La réservation de <strong><em>{$booking->getBooker()->getFullName()}</strong></em> a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_bookings_index');
    }
}
