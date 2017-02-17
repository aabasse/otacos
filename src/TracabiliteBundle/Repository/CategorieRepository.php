<?php

namespace TracabiliteBundle\Repository;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository
{
	public function getCategoriePere($idPere){
		return $this->createQueryBuilder('c')
			->andWhere('c.categoriePere = :categ')
			->setParameter('categ', $idPere)
			//->orderBy('c.libelle', 'ASC')
            ->getQuery()->getArrayResult();
	}
}