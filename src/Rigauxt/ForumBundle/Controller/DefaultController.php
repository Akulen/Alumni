<?php

namespace Rigauxt\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\ForumBundle\Entity\Categorie;

class DefaultController extends Controller
{
    public function indexAction($slugPere)
    {
    	$em = $this->getDoctrine()->getManager();
    	$categorieRepo = $em->getRepository("RigauxtForumBundle:Categorie");
    	$topicRepo = $em->getRepository("RigauxtForumBundle:Topic");
    	$pere = null;
    	$topics = null;
    	$postIts = null;
    	$titrePere = null;
    	if($slugPere != null)
    	{
    		$pere = $categorieRepo->findOneBy(array("slug" => $slugPere));
    		if($pere == null)
    			return $this->redirect($this->generateUrl("rigauxt_forum_index"));
    		else
    		{
    			$topics = $pere->getTopics();
    			foreach($topics as $topic)
    			{
    				if($topic->getType()->getName() != "Classique")
    				{
    					$postIts[] = $topic;
    					$topics->removeElement($topic);
    				}
    			}
    		}
    		$titrePere = $pere->getNom();
    	}
    	$categories = $categorieRepo->findBy(array("pere" => $pere), array("theme" => "asc"));
    	$ariane = array();
    	while($pere != null)
    	{
    		$ariane[$pere->getNom()] = $this->generateUrl("rigauxt_forum_index", array("slugPere" => $pere->getSlug()));
    		$pere = $pere->getPere();
    	}
    	$ariane["Forum"] = $this->generateUrl("rigauxt_forum_index");
    	$ariane = array_reverse($ariane);
    	$themes = array();
    	$curGroup = array();
    	$themesPost = array();
    	$curGroupPost = array();
    	foreach($categories as $id => $categorie)
    	{
    		if($id != 0 && $categorie->getTheme() != $prevCategorie->getTheme())
    		{
    			$themes[$prevCategorie->getTheme()] = $curGroup;
    			$curGroup = array();
    			$themesPost[$prevCategorie->getTheme()] = $curGroupPost;
    			$curGroupPost = array();
    		}
    		$curGroup[] = $categorie;
    		$curGroupPost[] = $categorieRepo->getLastPost($categorie->getId());
    		$prevCategorie = $categorie;
    	}
    	if(isset($prevCategorie))
    	{
	    	$themes[$prevCategorie->getTheme()] = $curGroup;
	    	$themesPost[$prevCategorie->getTheme()] = $curGroupPost;
	    }
	    $topicLastPost = array();
	    $postItLastPost = array();
	    if($topics != null)
	    {
			foreach($topics as $id => $topic)
			{
				$topicLastPost[$id] = $topicRepo->getLastPost($topic->getId());
			}
		}
	    if($postIts != null)
	    {
			foreach($postIts as $id => $topic)
			{
				$postItLastPost[$id] = $topicRepo->getLastPost($topic->getId());
			}
		}
        return $this->render('RigauxtForumBundle:Default:index.html.twig', array(
        	"themes"		=> $themes,
        	"themesPost"	=> $themesPost,
        	"ariane"		=> $ariane,
        	"topics"		=> $topics,
        	"topicLastPost"	=> $topicLastPost,
        	"slug"			=> $slugPere,
        	"titre"			=> $titrePere,
        	"postIts"		=> $postIts,
        	"postItLastPost"	=> $postItLastPost,
        ));
    }
}
