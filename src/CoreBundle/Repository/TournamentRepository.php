<?php

namespace CoreBundle\Repository;
use UserBundle\Entity\Account;
/**
 * TournamentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TournamentRepository extends \Doctrine\ORM\EntityRepository
{
	public function getByState($account_id)
	{
		$query = $this->createQueryBuilder('t')
			->select('COUNT(t)')
			->setParameter('account_id', $account_id)
			->where('t.account = :account_id')
			->AndWhere('t.state != 4')
			->getQuery();
		return $query->getSingleScalarResult();
	}

	public function findCurrentTournamentForAccount($account_id)
	{
		$query = $this->createQueryBuilder('t')
			->select('t')
			->setParameter('account_id', $account_id)
			->where('t.account = :account_id')
			->AndWhere('t.state != 5')
			->getQuery();
		return $query->getSingleResult();
	}

	public function getRegisteredTournamentForAccount($account_id)
	{
		$query = $this->createQueryBuilder('t')
			->select('t')
            ->leftJoin('t.accounts', 'a')
            ->setParameter('account_id', $account_id)
		    ->where('a.id = :account_id')
		    ->AndWhere('t.state != 5')
		    ->getQuery();
		return $query->getResult();
	}	
}
