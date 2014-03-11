<?php

namespace Rigauxt\AlumniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\AlumniBundle\Entity\Promotion;

class PromotionsController extends Controller
{
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$promoRepo = $em->getRepository("RigauxtAlumniBundle:Promotion");
		$promotions = $promoRepo->findBy(array(), array("annee" => "desc"));
		return $this->render('RigauxtAlumniBundle:Promotions:index.html.twig', array(
			"promotions" => $promotions,
		));
	}
}
