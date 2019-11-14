<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Form\CategorieType;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index()
    {
        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
        ]);
    }

    /**
     * @Route("/categories/ajouter", name="categorie_ajouter")
     */
    public function ajouter()
    {
        //je crée un objet catégorie vide
        $categorie=new Categorie();

        //créer le formulaire
        $formulaire=$this->createForm(CategorieType::Class, $categorie);//créer un formulaire vide
        return $this->render('categories/formulaire.html.twig',[
            "formulaire"=>$formulaire->createView()
            ,"h1"=>"Ajouter une catégorie"
        ]);
    }
}
