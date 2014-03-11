<?php

namespace Rigauxt\AlumniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\AlumniBundle\Entity\News;

class DefaultController extends Controller
{
	public function indexAction($page)
	{
		$em = $this->getDoctrine()->getManager();
		$newsRepo = $em->getRepository("RigauxtAlumniBundle:News");
		$nbNews = $newsRepo->getNbNews();
		if($page*5 > $nbNews || $page < 0)
			$page = 0;
		$listeNews = $newsRepo->findBy(array(),
									   array("date" => "desc"),
									   5,
									   $page*5);
		return $this->render('RigauxtAlumniBundle:Default:index.html.twig', array(
			"listeNews" => $listeNews,
			"nbPages" => round($nbNews/5+0.3),
			"curPage" => $page+1
		));
	}

	public function blogAction()
	{
		/*
		$news = new News();
		$news->setTitre("Test");
		$news->setAuteur("Rigauxt");
		$news->setContenu("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent urna magna, sagittis at lorem id, ultricies posuere elit. Proin nisi dui, lacinia eu turpis vitae, ornare pellentesque augue. Nulla facilisi. Praesent placerat quis tortor egestas pharetra. Nulla facilisi. Cras ante felis, laoreet vitae turpis feugiat, varius sollicitudin tortor. Mauris vitae est commodo, ultrices leo nec, commodo risus. Cras hendrerit laoreet nulla, dapibus viverra mi egestas volutpat. Cras pharetra nibh sit amet vestibulum auctor.");
		
		$em = $this->getDoctrine()->getManager();
		
		$em->persist($news);
		
		$em->flush();
		*/
		return $this->render('RigauxtAlumniBundle:Default:blog.html.twig');
	}

	public function assocAction()
	{
		return $this->render('RigauxtAlumniBundle:Default:assoc.html.twig');
	}

	public function adhesionAction()
	{
		return $this->render('RigauxtAlumniBundle:Default:adhesion.html.twig');
	}

	public function contactAction()
	{
		return $this->render('RigauxtAlumniBundle:Default:contact.html.twig');
	}

	public function changeLocaleAction()
	{
		return $this->redirect($this->generateUrl("rigauxt_alumni_index"));
	}
}
