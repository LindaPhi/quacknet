<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Entity\Quack;
use App\Form\DuckType;
use App\Repository\DuckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/duck")
 */
class DuckController extends AbstractController
{
    /**
     * @Route("/", name="duck_index", methods={"GET"})
     */
    public function index(DuckRepository $DuckRepository): Response
    {
        return $this->render('duck/index.html.twig', [
            'ducks' => $DuckRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="duck_show", methods={"GET"})
     */
    public function show(Duck $duck): Response
    {
        return $this->render('duck/show.html.twig', [
            'duck' => $duck,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="duck_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Duck $duck, UserPasswordEncoderInterface $UserPasswordEncoderInterface ): Response
    {

        $form = $this->createForm(DuckType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->all());
            $duck->setPassword($UserPasswordEncoderInterface->encodePassword($duck, $duck->getPassword()));
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('duck_index');
        }

        return $this->render('duck/edit.html.twig', [
            'duck' => $duck,
            'form' => $form->createView(),
        ]);
    }
//Comment
    /**
     * @Route("/{id}", name="duck_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Duck $duck): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duck->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($duck);
            $entityManager->flush();
        }

        return $this->redirectToRoute('duck_index');
    }
}
