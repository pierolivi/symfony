<?php

namespace Troiswa\BackBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Troiswa\BackBundle\Entity\Films;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Response;

class FilmsController extends Controller
{
   public function showfilmsAction()
    {



        $em=$this->getDoctrine()->getManager(); //recup de doctrine
        //$em:entity manager=$connexion dans le projet blog
        $touslesfilms=$em->getRepository("TroiswaBackBundle:Films")->findAll();

        //die(var_dump($touslesfilms));

        return $this->render("TroiswaBackBundle:Film:touslesfilms.html.twig",
          ["films"=>$touslesfilms]);
    }


        public function informationFilmAction($id)
        {


            $em=$this->getDoctrine()->getManager();
            $Film=$em->getRepository("TroiswaBackBundle:Films")->find($id);
          //die( var_dump($Film));
            if (empty($Film))
            {
                throw $this->createNotFoundException("Ce film n'existe pas");
            }

          return $this->render("TroiswaBackBundle:Film:film.html.twig",
              ["film"=>$Film]);
        }

    public function creerFilmAction(Request $request)   //$_Post,$_get
    {

        $nouveaufilm=new films();

        $form=$this->createFormBuilder($nouveaufilm)
            ->add("titre","text")
            ->add("description","textarea")
            ->add("datederealisation","date",

                [
                    "years" => range(date('Y')-50,date('2016'))
                ])
            ->add("note","number")
            ->add("fichier","file",
                [
                    "constraints"=>new NotBlank(["message" =>"Attention, pas d'image"])
                ])
            ->add("liaisonGenre","entity",
            [
                "class" => "TroiswaBackBundle:Genre",
                "property" => "type",
            ])
            ->add("ajouter","submit")
            ->getForm();


        $form->handleRequest($request);

        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $nouveaufilm->upload();
            $em->persist($nouveaufilm);    //surveille l'objet

            $em->flush();   //enregistrement en bdd
            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_genre","Le film a bien ete ajoute");

            return $this->redirect($this->generateURL("troiswa_back_info_film"));
        }


        return $this->render("TroiswaBackBundle:Film:creerfilm.html.twig",
            ["formfilm"=>$form->createView()]);
    }

}
