<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Acteurs;

class ActeurController extends Controller
{
    public function acteurAction(Request $request)
    {
        //die("je suis dans le controller");

        //return new Response("message");

       /* $touslesActeurs=[
            ["id"=>"1",
            "prenom"=>"tom",
            "nom"=>"cruise",
            "sexe"=>"1"],
            ["id"=>"2",
                "prenom"=>"giulia",
                "nom"=>"roberts",
                "sexe"=>"0"]
        ];*/


            $em=$this->getDoctrine()->getManager(); //recup de doctrine
            //$em:entity manager=$connexion dans le projet blog
        $touslesActeurs=$em->getRepository("TroiswaBackBundle:Acteurs")->findAll();

        //die(var_dump($touslesacteurs));

        $paginator=$this->get("knp_paginator");

        $paginationActeurs=$paginator->paginate(
            $touslesActeurs,
            $request->query->get("page",1),
            5);





       # return $this->render("TroiswaBackBundle:Acteur:touslesacteurs.html.twig",
        #  ["acteurs"=>$touslesActeurs]);
        return $this->render("TroiswaBackBundle:Acteur:touslesacteurs.html.twig",
        ["acteurs"=>$paginationActeurs]);
    }


        public function informationAction($id)
        {
            /*$touslesActeurs=[
                ["id"=>"1",
                    "prenom"=>"tom",
                    "nom"=>"cruise",
                    "sexe"=>"1"],
                ["id"=>"2",
                    "prenom"=>"giulia",
                    "nom"=>"roberts",
                    "sexe"=>"0"]

                ];*/
              /*  $acteur=[];
                foreach ($touslesActeurs as $cle => $value) {

                    //   var_dump($value);
                   //echo $value['id'];
                    if($id ==$value['id']) {

                        /*echo $value['prenom'];
                    echo $value['nom'];
                    echo $value['sexe'];
                    $acteur=[
                        "id"=>$value['id'],
                        "prenom"=>$value['prenom'],
                        "nom"=>$value['nom'],
                        "sexe"=>$value['sexe']
                    ];

                        $acteur = $value;

                    }
            }*/

            $em=$this->getDoctrine()->getManager();
            $Acteur=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);
          // die( var_dump($Acteur));
            if (empty($Acteur))
            {
                throw $this->createNotFoundException("Cet acteur n'existe pas");
            }

            return $this->render("TroiswaBackBundle:Acteur:acteur.html.twig",
                ["acteur2"=>$Acteur]);
        }

    public function ajouterActeurAction(Request $request)
    {

        $nouveauacteur=new Acteurs();   //nom dans le Entity


        $form=$this->createFormBuilder($nouveauacteur)
            ->add("sexe","choice",array(
                    "choices" => array(1=>"homme",0=>"femme"),
                    "expanded" => true,
                    'data' => 1
                    )
                )
            ->add("prenom","text")
            ->add("nom","text")
            ->add("datenaissance","date",
            [
                "years" => range(date('Y')-50,date('2016'))
            ])
            ->add("ville","text")
            ->add("biographie","textarea")
            //->add("image","text")
            ->add("liaisonFilms", "entity",
                ["class"=>"TroiswaBackBundle:Films",
                    "property"=>"titre",
                    "multiple"=>true])
            ->add("fichier","file",
            [
                "constraints"=>new NotBlank(["message" =>"Attention, pas d'image"])
            ])
            ->add("ajouter","submit")
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();

            $nouveauacteur->upload();
            $em->persist($nouveauacteur);
            $em->flush();   //enregistrement en bdd
            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_genre","L'acteur a bien ete ajoute");

            return $this->redirect($this->generateURL("troiswa_back_admin_acteur"));
        }
        //}

        return $this->render("TroiswaBackBundle:Acteur:ajouteracteur.html.twig",
            ["formacteur"=>$form->createView()]);


    }

    public function modifierActeurAction($id,Request $request)
    {


        $em = $this->getDoctrine()->getManager();

        $acteur = $em->getRepository("TroiswaBackBundle:Acteurs")->find($id);



        $form = $this->createFormBuilder($acteur)
            ->add("sexe", "choice", array(
                    "choices" => array(1 => "homme", 0 => "femme"),
                    "expanded" => true,
                    'data' => 1
                )
            )
            ->add("prenom", "text")
            ->add("nom", "text")
            //->add("datenaissance", "date")
            ->add("datenaissance","date",
                [
                    "years" => range(date('Y')-50,date('2016'))
                ])
            ->add("ville", "text")
            ->add("biographie", "textarea")
            //->add("image", "text")
            ->add("fichier","file", [
                'required' => false
            ])
            ->add("liaisonFilms", "entity",
            ["class"=>"TroiswaBackBundle:Films",
            "property"=>"titre",
            "multiple"=>true])
            ->add("modifier", "submit")
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $acteur->upload();
            $em->persist($acteur);    //surveille l'objet


            $em->flush();   //enregistrement en bdd
            $sessions = $request->getSession();
            $sessions->getFlashBag()->add("success_genre", "L'acteur a bien ete modifié");

            return $this->redirect($this->generateURL("troiswa_back_admin_acteur"));
        }
        return $this->render("TroiswaBackBundle:Acteur:modifieracteur.html.twig",
            ["formacteur"=>$form->createView()]);
    }

    public function supprimerActeurAction($id,Request $request)
    {

        #$genre= new Genre();

        $em=$this->getDoctrine()->getManager();

        $genre=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);




        $em->remove($genre);    //efface l'objet

        $em->flush();   //enregistrement en bdd
        $sessions=$request->getSession();
        $sessions->getFlashBag()->add("success_genre","L'acteur a bien ete supprime");

        return $this->redirect($this->generateURL("troiswa_back_admin_acteur"));



    }

}
