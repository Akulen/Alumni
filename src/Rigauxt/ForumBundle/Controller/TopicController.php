<?php

namespace Rigauxt\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\ForumBundle\Entity\Categorie;
use Rigauxt\ForumBundle\Entity\Post;
use Rigauxt\ForumBundle\Entity\Topic;
use Rigauxt\ForumBundle\Form\TopicType;

class TopicController extends Controller
{
    public function viewAction($slug)
    {
    	$em = $this->getDoctrine()->getManager();
    	$topicRepo = $em->getRepository("RigauxtForumBundle:Topic");
    	$topic = $topicRepo->findOneBy(array("slug" => $slug));
    	
    	$pere = $topic->getCategorie();
    	$ariane = array();
    	while($pere != null)
    	{
    		$ariane[$pere->getNom()] = $this->generateUrl("rigauxt_forum_index", array("slugPere" => $pere->getSlug()));
    		$pere = $pere->getPere();
    	}
    	$ariane["Forum"] = $this->generateUrl("rigauxt_forum_index");
    	$ariane = array_reverse($ariane);
    	$ariane[$topic->getTitle()] = "";
    	
        return $this->render('RigauxtForumBundle:Topic:view.html.twig', array(
        	"topic" => $topic,
        	"ariane" => $ariane,
        ));
    }
    
    public function newTopicAction($slug)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$user = $this->container->get('security.context')->getToken()->getUser();
		if($this == null || !$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			return $this->redirect($this->generateUrl("rigauxt_forum_index", array("slugPere" => $slug)));
		}
    	
    	$categorieRepo = $em->getRepository("RigauxtForumBundle:Categorie");
    	$categorie = $categorieRepo->findOneBy(array("slug" => $slug));
    	
    	$typeRepo = $em->getRepository("RigauxtForumBundle:Type");
    	$typeClassique = $typeRepo->findOneBy(array("name" => "Classique"));
    	
    	$topic = new Topic($user, $categorie);
    	$post = new Post($user, $topic);
    	$form = $this->createFormBuilder($post)
    				 ->add("message", "textarea")
    				 ->add("topic", new TopicType($categorie, $user, $typeClassique))
    				 ->getForm();
    				 
    	$request = $this->get("request");
		
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$post->getTopic()->setAuthor($user);
				$em->persist($post->getTopic());
				$em->persist($post);
				$em->flush();
				
				return $this->redirect($this->generateUrl("rigauxt_forum_topic_view", array("slug" => $topic->getSlug())));
			}
		}
    	
    	return $this->render('RigauxtForumBundle:Topic:newTopic.html.twig', array(
    		"form" => $form->createView(),
        	"slug" => $slug,
    	));
    }
    
    public function newPostAction($slug)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$topicRepo = $em->getRepository("RigauxtForumBundle:Topic");
    	$topic = $topicRepo->findOneBy(array("slug" => $slug));
    	
    	$user = $this->container->get('security.context')->getToken()->getUser();
		if($this == null || !$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			return $this->redirect($this->generateUrl("rigauxt_forum_index", array("slugPere" => $slug)));
		}
    	
    	$post = new Post($user, $topic);
    	$form = $this->createFormBuilder($post)
    				 ->add("message", "textarea")
    				 ->getForm();
    				 
    	$request = $this->get("request");
		
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em->persist($post);
				$em->flush();
				
				return $this->redirect($this->generateUrl("rigauxt_forum_topic_view", array("slug" => $post->getTopic()->getSlug())));
			}
		}
		
        return $this->render('RigauxtForumBundle:Topic:newPost.html.twig', array(
        	"form" => $form->createView(),
        	"slug" => $slug,
        ));
    }
}
