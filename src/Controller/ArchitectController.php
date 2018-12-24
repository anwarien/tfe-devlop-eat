<?php

namespace App\Controller;

use App\Entity\Architect;
use App\Form\ArchitectType;
use App\Repository\ArchitectRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ArchitectController extends Controller
{
    /**
     * @param ArchitectRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/architect", name="architect_list")
     */
    public function listProjects(ArchitectRepository $repo)
    {
        $architects = $repo->findAll();

        return $this->render('architect/architect_list.html.twig', [
            'architects' => $architects
        ]);
    }

    /**
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/admin/architect/add", name="architect_add")
     */
    public function addArchitect(Request $request, ObjectManager $manager)
    {
        $architect = new Architect();

        $form = $this->createForm(ArchitectType::class, $architect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($architect);
            $manager->flush();

            return $this->redirectToRoute('architect_list');
        }

        return $this->render('architect/architect_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Architect $architect
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/architect/{id}", name="architect_one")
     */
    public function oneProject(Architect $architect)
    {
        return $this->render('architect/architect_one.html.twig', [
            'architect' => $architect
        ]);
    }

    /**
     * @param Architect $architect
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/admin/architect/delete/{id}", name="architect_delete")
     * @ParamConverter("architect", options={"exclude": {"manager"}})
     */
    public function deletePoject(Architect $architect, ObjectManager $manager)
    {
        $manager->remove($architect);
        $manager->flush();

        return $this->redirectToRoute('architect_list');
    }

    /**
     * @param Architect $architect
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/architect/update/{id}", name="architect_update")
     * @ParamConverter("architect", options={"exclude": {"request","manager"}})
     */
    public function updateProject(Architect $architect, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(ArchitectType::class, $architect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($architect);
            $manager->flush();

            return $this->render('architect/architect_one.html.twig', [
                'architect' => $architect
            ]);
        }

        return $this->render('architect/architect_update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}