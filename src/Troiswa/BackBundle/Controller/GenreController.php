<?php

namespace Troiswa\BackBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
   public function allAction()
    {



        $em=$this->getDoctrine()->getManager(); //recup de doctrine
        //$em:entity manager=$connexion dans le projet blog
        $touslesgenres=$em->getRepository("TroiswaBackBundle:Genre")->findAll();

        //die(var_dump($touslesgenres));

        return $this->render("TroiswaBackBundle:Film:touslesgenres.html.twig",
          ["genre"=>$touslesgenres]);
    }


        public function creerAction(Request $request)   //$_Post,$_get
        {

        $nouveaugenre=new genre();

        $form=$this->createFormBuilder($nouveaugenre)
            ->add("type","text")
            ->add("description","textarea")
            ->add("ajouter","submit")
            ->getForm();
            #if ($request ->isMethod("POST"))
            #{
               # $form->submit($request);
                //die(var_dump($nouveaugenre));

            $form->handleRequest($request);

                if($form->isValid())
                {
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($nouveaugenre);    //surveille l'objet
                    //$nouveaugenre->setType("toto");
                    $em->flush();   //enregistrement en bdd
                    $sessions=$request->getSession();
                    $sessions->getFlashBag()->add("success_genre","Le genre a bien ete ajoute");

                    return $this->redirect($this->generateURL("troiswa_back_genre"));
                }
            #}

            return $this->render("TroiswaBackBundle:Film:creergenre.html.twig",
                ["formgenre"=>$form->createView()]);
        }

        public function modifierAction($id,Request $request)
        {

            //$genre= new Genre();
            //$genre->setType("toto");
            $em=$this->getDoctrine()->getManager();

            $genre=$em->getRepository("TroiswaBackBundle:Genre")->find($id);

            $form=$this->createFormBuilder($genre)
                ->add("type","text")
                ->add("description","textarea")
                ->add("modifier","submit")
                ->getForm();

            $form->handleRequest($request);

            if($form->isValid())
            {
                //$em->persist($genre);    //surveille l'objet
                //$nouveaugenre->setType("toto");
                $em->flush();   //enregistrement en bdd
                $sessions=$request->getSession();
                $sessions->getFlashBag()->add("success_genre","Le genre a bien ete modifié");

                return $this->redirect($this->generateURL("troiswa_back_genre"));
            }
            //}

            return $this->render("TroiswaBackBundle:Film:modifiergenre.html.twig",
                ["formgenre"=>$form->createView()]);


        }

    public function supprimerAction($id,Request $request)
    {

        #$genre= new Genre();

        $em=$this->getDoctrine()->getManager();

        $genre=$em->getRepository("TroiswaBackBundle:Genre")->find($id);




            $em->remove($genre);    //efface l'objet

            $em->flush();   //enregistrement en bdd
            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_genre","Le genre a bien ete supprime");

           return $this->redirect($this->generateURL("troiswa_back_genre"));



    }
}
