<?php
namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Security;

class OnRequestListener {
    private $em;
    private $security;

    /**
     * OnRequestListener constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $user = $this->security->getUser();

        if ($user instanceof User) {
            // Enable the filter
            $filter = $this->em->getFilters()->enable('user_filter');
            $filter->setParameter('deals', $user->getDeals());
        }
    }
}