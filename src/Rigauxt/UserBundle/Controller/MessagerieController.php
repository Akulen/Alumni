<?php

namespace Rigauxt\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\UserBundle\Entity\User;

class MessagerieController extends Controller
{
	public function indexAction()
	{
		return $this->render('RigauxtUserBundle:Messagerie:index.html.twig');
	}
}
