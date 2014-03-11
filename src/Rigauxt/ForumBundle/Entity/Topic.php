<?php

namespace Rigauxt\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Topic
 *
 * @ORM\Table("alumni_forum_topic")
 * @ORM\Entity(repositoryClass="Rigauxt\ForumBundle\Entity\TopicRepository")
 */
class Topic
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Rigauxt\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Rigauxt\ForumBundle\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Rigauxt\ForumBundle\Entity\Categorie", inversedBy="topics", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;
    
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    
    /**
     * @ORM\OneToMany(targetEntity="Rigauxt\ForumBundle\Entity\Post", mappedBy="topic")
     */
    private $posts;


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
     * Set title
     *
     * @param string $title
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set categorie
     *
     * @param \Rigauxt\ForumBundle\Entity\Categorie $categorie
     * @return Topic
     */
    public function setCategorie(\Rigauxt\ForumBundle\Entity\Categorie $categorie)
    {
    	if($this->categorie != null)
    		$this->categorie->removeTopic($this);
    	$categorie->addTopic($this);
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Rigauxt\ForumBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set author
     *
     * @param \Rigauxt\UserBundle\Entity\User $author
     * @return Topic
     */
    public function setAuthor(\Rigauxt\UserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Rigauxt\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Topic
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
     * Constructor
     */
    public function __construct(\Rigauxt\UserBundle\Entity\User $user, \Rigauxt\ForumBundle\Entity\Categorie $categorie)
    {
    	$this->user = $user;
    	$this->setCategorie($categorie);
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add posts
     *
     * @param \Rigauxt\ForumBundle\Entity\Post $posts
     * @return Topic
     */
    public function addPost(\Rigauxt\ForumBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Rigauxt\ForumBundle\Entity\Post $posts
     */
    public function removePost(\Rigauxt\ForumBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set type
     *
     * @param \Rigauxt\ForumBundle\Entity\Type $type
     * @return Topic
     */
    public function setType(\Rigauxt\ForumBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Rigauxt\ForumBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }
}
