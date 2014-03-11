<?php

namespace Rigauxt\ForumBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends EntityRepository
{
	public function getLastPost($id)
	{
		$retour = $this->getEntityManager()
						->createQueryBuilder()
						->select('c')
						->from('RigauxtForumBundle:Categorie', 'c')
						->where('c.id = :id')
						->setParameter('id', $id)
						->leftJoin('c.topics', 't')
						->addSelect('t')
						->leftJoin('t.posts', 'p')
						->addSelect('p')
						->OrderBy('p.date', 'DESC')
						->getQuery()
						->setFirstResult(0)
						->setMaxResults(1)
						->getOneOrNullResult();
		$latest = null;
		if($retour != null)
			$latest = $retour->getTopics()->first()->getPosts()->first();
		foreach($retour->getFils() as $categories)
		{
			$temp = $this->getLastPost($categories->getId());
			if($latest == null || $latest->getDate() < $temp->getDate())
				$latest = $temp;
		}
		return $latest;
	}
}
