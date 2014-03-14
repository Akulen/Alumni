<?php

namespace Rigauxt\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Categorie
 *
 * @ORM\Table("alumni_forum_categorie")
 * @ORM\Entity(repositoryClass="Rigauxt\ForumBundle\Entity\CategorieRepository")
 */
class Categorie
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="Rigauxt\ForumBundle\Entity\Categorie", inversedBy="fils", cascade={"persist"})
     */
    private $pere;
    
    /**
     * @ORM\OneToMany(targetEntity="Rigauxt\ForumBundle\Entity\Categorie", mappedBy="pere")
     */
    private $fils;
    
    /**
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    
    /**
     * @ORM\OneToMany(targetEntity="Rigauxt\ForumBundle\Entity\Topic", mappedBy="categorie", cascade="remove")
     */
    private $topics;
    
    /**
     * @ORM\ManyToOne(targetEntity="Rigauxt\ForumBundle\Entity\Theme")
     */
    private $theme;

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
     * Set nom
     *
     * @param string $nom
     * @return Categorie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Categorie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fils = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set pere
     *
     * @param \Rigauxt\ForumBundle\Entity\Categorie $pere
     * @return Categorie
     */
    public function setPere(\Rigauxt\ForumBundle\Entity\Categorie $pere = null)
    {
    	if($this->pere != null)
    		$this->pere->removeFil($this);
    	$pere->addFil($this);
        $this->pere = $pere;

        return $this;
    }

    /**
     * Get pere
     *
     * @return \Rigauxt\ForumBundle\Entity\Categorie 
     */
    public function getPere()
    {
        return $this->pere;
    }

    /**
     * Add fils
     *
     * @param \Rigauxt\ForumBundle\Entity\Categorie $fils
     * @return Categorie
     */
    public function addFil(\Rigauxt\ForumBundle\Entity\Categorie $fils)
    {
        $this->fils[] = $fils;

        return $this;
    }

    /**
     * Remove fils
     *
     * @param \Rigauxt\ForumBundle\Entity\Categorie $fils
     */
    public function removeFil(\Rigauxt\ForumBundle\Entity\Categorie $fils)
    {
        $this->fils->removeElement($fils);
    }

    /**
     * Get fils
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFils()
    {
        return $this->fils;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Categorie
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add topics
     *
     * @param \Rigauxt\ForumBundle\Entity\topic $topics
     * @return Categorie
     */
    public function addTopic(\Rigauxt\ForumBundle\Entity\topic $topics)
    {
        $this->topics[] = $topics;

        return $this;
    }

    /**
     * Remove topics
     *
     * @param \Rigauxt\ForumBundle\Entity\topic $topics
     */
    public function removeTopic(\Rigauxt\ForumBundle\Entity\topic $topics)
    {
        $this->topics->removeElement($topics);
    }

    /**
     * Get topics
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return Categorie
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
