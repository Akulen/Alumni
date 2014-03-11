<?php

namespace Rigauxt\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table("alumni_forum_post")
 * @ORM\Entity(repositoryClass="Rigauxt\ForumBundle\Entity\PostRepository")
 */
class Post
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
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Rigauxt\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;
    
    /**
     * @ORM\ManyToOne(targetEntity="Rigauxt\ForumBundle\Entity\Topic", inversedBy="posts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $topic;
    
	public function __construct(\Rigauxt\UserBundle\Entity\User $user, \Rigauxt\ForumBundle\Entity\Topic $topic)
	{
		$this->date = new \Datetime();
		$this->setAuthor($user);
		$this->setTopic($topic);
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
     * Set message
     *
     * @param string $message
     * @return Post
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Post
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param \Rigauxt\UserBundle\Entity\User $author
     * @return Post
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
     * Set topic
     *
     * @param \Rigauxt\ForumBundle\Entity\Topic $topic
     * @return Post
     */
    public function setTopic(\Rigauxt\ForumBundle\Entity\Topic $topic)
    {
    	if($this->topic != null)
    		$this->topic->removePost($this);
    	$topic->addPost($this);
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \Rigauxt\ForumBundle\Entity\Topic 
     */
    public function getTopic()
    {
        return $this->topic;
    }
    
    public function getTimeSince()
    {
    	$now = new \DateTime('now');
    	if(gmdate('Y', $now->format('U') - $this->date->format('U')) - 1970)
    		return (string)(gmdate('Y', $now->format('U') - $this->date->format('U'))-1970) . " ans";
    	if(gmdate('m', $now->format('U') - $this->date->format('U'))-1)
    		return (string)(gmdate('m', $now->format('U') - $this->date->format('U'))-1) . " mois";
    	if(gmdate('d', $now->format('U') - $this->date->format('U'))-1)
    		return (string)(gmdate('d', $now->format('U') - $this->date->format('U'))-1) . " jours";
    	if(gmdate('H', $now->format('U') - $this->date->format('U')) != "00")
    		return (string)gmdate('H', $now->format('U') - $this->date->format('U')) . " heures";
    	if(gmdate('i', $now->format('U') - $this->date->format('U')) != "00")
    		return (string)gmdate('i', $now->format('U') - $this->date->format('U')) . " minutes";
    	else
    		return (string)gmdate('s', $now->format('U') - $this->date->format('U')) . " secondes";
    }
}
