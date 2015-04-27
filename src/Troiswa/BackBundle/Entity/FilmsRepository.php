<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FilmsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FilmsRepository extends EntityRepository
{

    public function getNombreDeFilm()
    {
        //die("test");
        $query=$this->getEntityManager()->createQuery(
           " SELECT COUNT(f) FROM TroiswaBackBundle:Films f"
        );

        //die(var_dump($query->getResult()));

        //die(var_dump($query->getSingleScalarResult()));

        return $query->getSingleScalarResult();
    }

    public function getMeilleurFilm()
    {
        //die("test");
        $query=$this->getEntityManager()->createQuery(
            " SELECT f.id, f.titre FROM TroiswaBackBundle:Films f ORDER BY f.note DESC"
        );

        //die(var_dump($query->getResult()));

       //die(var_dump($query->setMaxResults(1)->getSingleResult()));

        return $query->setMaxResults(1)->getSingleResult();
    }

    public function getLiaisonfilm($type)
    {
        //die("test");
        $query=$this->getEntityManager()->createQuery(
            " SELECT f FROM TroiswaBackBundle:Films f JOIN f.liaisonGenre g WHERE g.type = :letype"
        );

        //die(var_dump($query->getResult()));

        //die(var_dump($query->setParameter("letype",$type)->getResult()));

        return $query->setParameter("letype",$type)->getResult();
    }
}
