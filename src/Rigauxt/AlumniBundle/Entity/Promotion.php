<?php

namespace Rigauxt\AlumniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rigauxt\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Promotion
 *
 * @ORM\Table("alumni_promotion")
 * @ORM\Entity(repositoryClass="Rigauxt\AlumniBundle\Entity\PromotionRepository")
 */
class Promotion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Annee", type="string", length=255)
     */
    private $annee;
    
    /**
     * @ORM\OneToMany(targetEntity="Rigauxt\UserBundle\Entity\User", mappedBy="promotion")
     * @ORM\OrderBy({"nom"="ASC", "prenom"="ASC"})
     */
    private $users;
	
	public function __construct()
	{
		$this->users = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
	
    /**
     * Set annee
     *
     * @param string $annee
     * @return Promotion
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Add users
     *
     * @param \Rigauxt\UserBundle\Entity\User $users
     * @return Promotion
     */
    public function addUser(\Rigauxt\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Rigauxt\UserBundle\Entity\User $users
     */
    public function removeUser(\Rigauxt\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
