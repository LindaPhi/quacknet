<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/quack")
 */
class QuackController extends AbstractController
{
    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @Route("/", name="quack_index", methods={"GET"})
     */
    public function index(QuackRepository $quackRepository): Response
    {
        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quack_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
            $quack = new Quack();
            $form = $this->createForm(QuackType::class, $quack);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $uploaded_data = $form->all()['upload']->getData();
                $originalFilename = pathinfo($uploaded_data->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploaded_data->guessExtension();
                try {
                    $uploaded_data->move(
                        $this->getParameter('upload_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd("Dont Move !");
                }
                dd("fin");
                dd($uploaded_data);
                $quack = setCreatedAt(new \DateTime('now'));
                dd($quack);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($quack);
                $entityManager->flush();
                return $this->redirectToRoute('quack_index');
            }

            return $this->render('quack/new.html.twig', [
                'quack' => $quack,
                'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/{id}", name="quack_show", methods={"GET"})
     */
    public function show(Quack $quack): Response
    {
        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quack $quack): Response
    {
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quack $quack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_index');
    }
}
