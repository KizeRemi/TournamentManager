<?php

namespace CoreBundle\Service;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Account;
use Doctrine\ORM\EntityManager;

class SetExperience
{
	private $em;

    public function __construct(EntityManager $entityManager)
    {
    	 $this->em = $entityManager;
    }

	public function setExperienceToAccount(Account $account, $experience)
	{
		$currentExperience = $account->getCurrentExp();
		$currentLevel =  $account->getLevel();
		$experienceTotal = $currentExperience+$experience;

		if($experienceTotal >= $currentLevel->getRequired()){
       		$level = $this->em->getRepository('CoreBundle:Level')->findOneByLevel($currentLevel->getlevel()+1);
       		$currentExp = $experienceTotal-$currentLevel->getRequired();
       		$account->setCurrentExp($currentExp);
       		$account->setLevel($level);
		} else {
			$account->setCurrentExp($currentExperience+$experience);
		}

        $this->em->persist($account);
        $this->em->flush();

	}
}