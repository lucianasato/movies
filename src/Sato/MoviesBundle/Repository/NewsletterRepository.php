<?php

namespace Sato\MoviesBundle\Repository;

use Doctrine\ORM\EntityRepository;


class NewsletterRepository extends EntityRepository
{

    public function search( $search )
    {
        $sql = $this->createQueryBuilder('a')
                    ->select('a')
                    ->where('a.email = :email')
                    ->orderBy('a.id')
                    ->setParameter('email', $search['email']);

        return $sql->getQuery()->getResult();
    }
}