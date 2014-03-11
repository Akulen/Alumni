<?php

namespace Rigauxt\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\BlogBundle\Entity\Article;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DefaultController extends Controller
{
    public function indexAction($page)
    {
    	$em = $this->getDoctrine()->getManager();
    	$articleRepo = $em->getRepository("RigauxtBlogBundle:Article");
    	$nbArticles = $articleRepo->getNbArticles();
		if($page*5 > $nbArticles || $page < 0)
			$page = 0;
		$listeArticles = $articleRepo->findBy(array(),
											  array("date" => "desc"),
											  5,
											  $page*5);
        return $this->render('RigauxtBlogBundle:Default:index.html.twig', array(
        	"listeArticles" => $listeArticles,
			"nbPages" => round($nbArticles/5+0.3),
			"curPage" => $page+1
        ));
    }
    
    public function voirAction($slug)
    {
    	$em = $this->getDoctrine()->getManager();
    	$articleRepo = $em->getRepository("RigauxtBlogBundle:Article");
		$article = $articleRepo->findOneBy(array("slug" => $slug));
		if($article == null)
			return $this->redirect($this->generateUrl("rigauxt_blog_index"));
        return $this->render('RigauxtBlogBundle:Default:voir.html.twig', array(
        	"article" => $article
        ));
    }
    
	public function addAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		if(!$this->get('security.context')->isGranted('ROLE_AUTEUR'))
		{
			throw new AccessDeniedHttpException('Accès limité aux auteurs');
		}
		$article = new Article($user);
		
		$form = $this->createFormBuilder($article)
					 ->add("titre",		"text")
					 ->add("contenu",	"textarea")
					 ->getForm();
		
		$request = $this->get("request");
		
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();
				
				return $this->redirect($this->generateUrl("rigauxt_blog_index"));
			}
		}
		
		return $this->render("RigauxtBlogBundle:Default:add.html.twig", array(
			"form" => $form->createView(),
		));
	}
	
	public function editAction($slug)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$em = $this->getDoctrine()->getManager();
		$articleRepo = $em->getRepository("RigauxtBlogBundle:Article");
		$article = $articleRepo->findOneBy(array("slug" => $slug));
		if(!($this->get('security.context')->isGranted('ROLE_ADMIN') || $article->getAuteur() == $user))
		{
			throw new AccessDeniedHttpException('Accès limité à l\'auteur');
		}
		
		if($article == null)
			return $this->redirect($this->generateUrl("rigauxt_blog_index"));
		
		$form = $this->createFormBuilder($article)
					 ->add("titre",		"text")
					 ->add("contenu",	"textarea")
					 ->getForm();
		
		$request = $this->get("request");
		
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em->flush();
				
				return $this->redirect($this->generateUrl("rigauxt_blog_index"));
			}
		}
		
		return $this->render("RigauxtBlogBundle:Default:edit.html.twig", array(
			"form"	=> $form->createView(),
			"slug"	=> $slug,
			"titre"	=> $article->getTitre(),
		));
	}
	
	public function removeAction($slug)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$em = $this->getDoctrine()->getManager();
		$articleRepo = $em->getRepository("RigauxtBlogBundle:Article");
		$article = $articleRepo->findOneBy(array("slug" => $slug));
		if(!($this->get('security.context')->isGranted('ROLE_ADMIN') || $article->getAuteur() == $user))
		{
			throw new AccessDeniedHttpException('Accès limité aux auteurs');
		}
		if($article == null)
			return $this->redirect($this->generateUrl("rigauxt_blog_index"));
		$em->remove($article);
		$em->flush();
		return $this->redirect($this->generateUrl("rigauxt_blog_index"));
	}
}
