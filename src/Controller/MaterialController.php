<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterialController extends Controller
{
    /**
     * @var MaterialRepository
     */
    private $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }


    /**
     * @Route("/materials/new", name="materials_new_form", methods={"GET"})
     * @Route("/materials/", name="materials_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $material = new Material();
        $form = $this->createForm(MaterialType::class, $material, [
            'action' => $this->generateUrl('materials_create'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($material);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('materials_update', ['id'=>$material->getId()]);
        }

        return $this->render('materials/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/materials/{id}/", name="materials_update", methods={"GET","POST"})
     */
    public function update(Request $request, Material $material): Response
    {
        $form = $this->createForm(MaterialType::class, $material, [
            'action' => $this->generateUrl('materials_update', ['id' => $material->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($material);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('materials_update', ['id'=>$material->getId()]);
        }

        return $this->render('materials/update.html.twig', [
            'form' => $form->createView(),
            'material' => $material,
        ]);
    }

    /**
     * @Route("/materials/", name="materials_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('materials/list.html.twig', [
            'materials' => $this->materialRepository->findAll(),
        ]);
    }
}