<?php
declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(): Response
    {
        return $this->render('dashboard.html.twig', [
            'homeGroups' => $this->getUser()->getHomeGroups(),
        ]);
    }

}