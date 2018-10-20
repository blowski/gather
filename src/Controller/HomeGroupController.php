<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\HomeGroup;
use App\Form\HomeGroupType;
use App\Form\JoinHomeGroupType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeGroupController extends Controller
{
    /**
     * @Route("/homegroups/new", name="homegroup_new_form", methods={"GET"})
     * @Route("/homegroups/", name="homegroup_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $homeGroup = new HomeGroup();
        $form = $this->createForm(HomeGroupType::class, $homeGroup, [
            'action' => $this->generateUrl('homegroup_create'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $homeGroup->addMember($this->getUser());
            $this->getDoctrine()->getManager()->persist($homeGroup);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homegroup_show', ['id'=>$homeGroup->getId()]);
        }

        return $this->render('homegroups/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/homegroups/{id}/", name="homegroup_show", methods={"GET"})
     */
    public function show(HomeGroup $homeGroup): Response
    {
        return $this->render('homegroups/show.html.twig', [
            'homeGroup' => $homeGroup,
        ]);
    }

    /**
     * @Route("/homegroups/join", name="homegroup_join", methods={"GET","POST"})
     */
    public function join(Request $request)
    {
        $form = $this->createForm(JoinHomeGroupType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $repo = $this->getDoctrine()->getRepository(HomeGroup::class);
            $homeGroup = $repo->findOneBy(['code' => $form['code']->getData()]);
            $homeGroup->addMember($this->getUser());
            $this->getDoctrine()->getManager()->persist($homeGroup);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homegroup_show', ['id' => $homeGroup->getId()]);

        }

        return $this->render('homegroups/join.html.twig', [
            'form' => $form->createView()
        ]);
    }
}