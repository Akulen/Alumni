<?php

namespace Rigauxt\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\AlumniBundle\Entity\News;
use Rigauxt\UserBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class NewsController extends Controller
{
	public function addAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		if(!$this->get('security.context')->isGranted('ROLE_AUTEUR'))
		{
			throw new AccessDeniedHttpException('Accès limité aux auteurs');
		}
		$news = new News($user);
		
		$form = $this->createFormBuilder($news)
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
				$em->persist($news);
				$em->flush();
				
				return $this->redirect($this->generateUrl("rigauxt_alumni_index"));
			}
		}
		
		return $this->render("RigauxtNewsBundle:News:add.html.twig", array(
			"form" => $form->createView(),
		));
	}
	
	public function editAction($slug)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$em = $this->getDoctrine()->getManager();
		$newsRepo = $em->getRepository("RigauxtAlumniBundle:News");
		$news = $newsRepo->findOneBy(array("slug" => $slug));
		if(!($this->get('security.context')->isGranted('ROLE_ADMIN') || $news->getAuteur() == $user))
		{
			throw new AccessDeniedHttpException('Accès limité à l\'auteur');
		}
		
		if($news == null)
			return $this->redirect($this->generateUrl("rigauxt_alumni_index"));
		
		$form = $this->createFormBuilder($news)
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
				
				return $this->redirect($this->generateUrl("rigauxt_alumni_index"));
			}
		}
		
		return $this->render("RigauxtNewsBundle:News:edit.html.twig", array(
			"form"	=> $form->createView(),
			"slug"	=> $slug,
			"titre"	=> $news->getTitre(),
		));
	}
	
	public function removeAction($slug)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$em = $this->getDoctrine()->getManager();
		$newsRepo = $em->getRepository("RigauxtAlumniBundle:News");
		$news = $newsRepo->findOneBy(array("slug" => $slug));
		if($news == null || !($this->get('security.context')->isGranted('ROLE_ADMIN') || $news->getAuteur() == $user))
		{
			throw new AccessDeniedHttpException('Accès limité aux auteurs');
		}
		$em->remove($news);
		$em->flush();
		return $this->redirect($this->generateUrl("rigauxt_alumni_index"));
	}
}
