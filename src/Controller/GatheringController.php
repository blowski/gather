<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Gathering;
use App\Entity\HomeGroup;
use App\Form\CommentType;
use App\Form\GatheringType;
use App\Repository\GatheringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GatheringController extends Controller
{
    /**
     * @var GatheringRepository
     */
    private $gatheringRepository;

    public function __construct(GatheringRepository $gatheringRepository)
    {
        $this->gatheringRepository = $gatheringRepository;
    }


    /**
     * @Route("/homegroups/{id}/gatherings/new", name="gathering_new_form", methods={"GET"})
     * @Route("/homegroups/{id}/gatherings/", name="gathering_create", methods={"POST"})
     */
    public function create(HomeGroup $homeGroup, Request $request): Response
    {
        $gathering = new Gathering();
        $form = $this->createForm(GatheringType::class, $gathering, [
            'action' => $this->generateUrl('gathering_create', ['id' => $homeGroup->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $gathering->setHomeGroup($homeGroup);
            $this->getDoctrine()->getManager()->persist($gathering);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gathering_list', ['id'=>$homeGroup->getId()]);
        }

        return $this->render('gatherings/new.html.twig', [
            'form' => $form->createView(),
            'gathering' => $gathering,
            'homeGroup' => $homeGroup,
        ]);
    }

    /**
     * @Route("/homegroups/{id}/gatherings/", name="gathering_list", methods={"GET"})
     */
    public function index(HomeGroup $homeGroup): Response
    {
        return $this->render('gatherings/list.html.twig', [
            'gatherings' => $this->gatheringRepository->findBy(['homeGroup' => $homeGroup], ['startDate' => 'DESC']),
            'homeGroup' => $homeGroup,
        ]);
    }

    /**
     * @Route("/gatherings/{id}/", name="gathering_show", methods={"GET"})
     */
    public function show(Gathering $gathering): Response
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $commentForm = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('gathering_comment', ['id' => $gathering->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('gatherings/show.html.twig', [
            'gathering' => $gathering,
            'commentForm' => $commentForm->createView(),
        ]);
    }

    /**
     * @Route("/gatherings/{id}/comments/", name="gathering_comment", methods={"POST"})
     */
    public function comment(Gathering $gathering, Request $request): Response
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('gathering_comment', ['id' => $gathering->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $gathering->addComment($comment);
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gathering_show', [
                'id' => $gathering->getId(),
            ]);
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}