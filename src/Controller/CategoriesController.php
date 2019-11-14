<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index()
    {
        //JE VAIS CHERCHER LE REPOSITORY
        $repository=$this->getDoctrine()->getRepository(Categorie::class);

        //je fais un select *
        $categories=$repository->findALL();

        return $this->render('categories/index.html.twig', [
            "categories"=>$categories
        ]);
    }

    /**
     * @Route("/categories/ajouter", name="categorie_ajouter")
     */
    public function ajouter(Request $request)
    {
        //je crée un objet catégorie vide
        $categorie=new Categorie();

        //créer le formulaire
        $formulaire=$this->createForm(CategorieType::Class, $categorie);//créer un formulaire vide

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //recuperation de l'entity manager
            $em=$this->getDoctrine()->getManager();
            // je dis ou manager de garder cet objet en BDD
            $em->persist($categorie);
            //execute l'insert
            $em->flush();

            //je m'en vais
          return  $this->redirectToRoute("categories");
        }

        return $this->render('categories/formulaire.html.twig',[
            "formulaire"=>$formulaire->createView()
            ,"h1"=>"Ajouter une catégorie"
        ]);
    }

    /**
     * @Route("/categories/modifier/{id}", name="categorie_modifier")
     */
    public function modifier(Request $request, $id)
    {
        //je vais cherhcer l'objet a modifier
       $repository=$this->getDoctrine()->getRepository(Categorie::class);
       $categorie=$repository->find($id);

        //créer le formulaire
        $formulaire=$this->createForm(CategorieType::Class, $categorie);//créer un formulaire vide

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //recuperation de l'entity manager
            $em=$this->getDoctrine()->getManager();
            // je dis ou manager de garder cet objet en BDD
            $em->persist($categorie);
            //execute l'update
            $em->flush();

            //je m'en vais
          return  $this->redirectToRoute("categories");
        }

        return $this->render('categories/formulaire.html.twig',[
            "formulaire"=>$formulaire->createView()
            ,"h1"=>"Modifier la catégorie ".$categorie->getTitre()
        ]);
    }
}
