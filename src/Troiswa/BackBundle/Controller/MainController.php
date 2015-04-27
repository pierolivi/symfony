<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
   public function mainAction()
   {
      //die("je suis dans le controller");

      //return new Response("message");

       $em=$this->getDoctrine()->getManager();

       $nbFilms=$em->getRepository("TroiswaBackBundle:Films")->getNombreDeFilm();
       $meilleur=$em->getRepository("TroiswaBackBundle:Films")->getMeilleurFilm();
       $filmsAction=$em->getRepository("TroiswaBackBundle:Films")->getLiaisonfilm('action');


      return $this->render("TroiswaBackBundle:Main:admin.html.twig",
          ["NB"=>"$nbFilms","Meilleurfilm"=>$meilleur]);


   }





}
