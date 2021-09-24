<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Personne;
use App\Form\EquipeType;
use App\Form\PersonneType;
use App\Repository\EquipeRepository;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EquipeRepository $repoEquipe, PersonneRepository $repoPersonne, Request $request): Response
    {
        $equipe = new Equipe();
        $formEquipe = $this->createForm(EquipeType::class,$equipe);
        $personne = new Personne();
        $formPersonne = $this->createForm(PersonneType::class,$personne);

        if('POST' === $request->getMethod()) {
            $formEquipe->handleRequest($request);
            $formPersonne->handleRequest($request);

            if ($formEquipe->isSubmitted() and $formEquipe->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($equipe);
                $em->flush();
                unset($formItem);
                unset($item);
                $equipe = new Equipe();
                $formEquipe = $this->createForm(EquipeType::class,$equipe);
            }

            if ($formPersonne->isSubmitted() and $formPersonne->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($personne);
                $em->flush();
                unset($formItem);
                unset($item);
                $personne = new Personne();
                $formPersonne = $this->createForm(PersonneType::class,$personne);
            }
        }
        $listEquipe = $repoEquipe->findAll();
        $listPersonne = $repoPersonne->findAll();
        return $this->render('main/index.html.twig', [
            'listEquipe' => $listEquipe,
            'listPersonne' => $listPersonne,
            'formEquipe' => $formEquipe->createView(),
            'formPersonne' => $formPersonne->createView()
        ]);
    }

    /**
     * @Route("/effacerEquipe/{id}", name="effacer_equipe")
     */
    public function effacerEquipe(EquipeRepository $repoEquipe, $id): Response
    {
        $equipe = $repoEquipe->findOneBy(
            [
                'id'=>$id
            ]
        );
        $em = $this->getDoctrine()->getManager();
        $em->remove($equipe);
        $em->flush();
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/effacerPersonne/{id}", name="effacer_personne")
     */
    public function effacerPersonne(PersonneRepository $repoPersonne, $id): Response
    {
        $personne = $repoPersonne->findOneBy(
            [
                'id'=>$id
            ]
        );
        $em = $this->getDoctrine()->getManager();
        $em->remove($personne);
        $em->flush();
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/retirerJoueur/{id}", name="retirer_personne")
     */
    public function retirerJoueurEquipê(PersonneRepository $repoPersonne, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $personne = $entityManager->getRepository(Personne::class)->find($id);
        $personne->setEquipeId(null);
        $entityManager->flush();
        return $this->redirectToRoute('index');
    }
}
