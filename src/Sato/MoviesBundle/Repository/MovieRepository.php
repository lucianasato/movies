<?php

namespace Sato\MoviesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MovieRepository extends EntityRepository
{
    public function search( $search )
    {

        $sql = $this->createQueryBuilder('a')
            ->leftJoin('a.distributor_id', 'd')
            ->addSelect('d');

        if ( ! empty( $search['title'] ) ) {
            $sql->andWhere('a.title like :title')
                ->setParameter('title' , '%' . $search['title'] . '%' );
        }

        if ( ! empty( $search['country'] )) {
            $sql->andWhere('a.country_id = :country')
                ->setParameter('country', $search['country'] );
        }

        if ( ! empty( $search['distributor'] )) {
            $sql->andWhere('d.name LIKE :distributor')
                ->setParameter('distributor', '%'.$search['distributor'].'%');
        }

        return $sql->getQuery()->getResult();
    }
}