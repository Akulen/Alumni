<?php

namespace Rigauxt\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\UserBundle\Entity\User;

class ProfilController extends Controller
{
	public function showAction($username)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		if(is_object($user) && $user->getUsername() == $username)
			return $this->redirect($this->generateUrl("fos_user_profile_show"));
		$em = $this->getDoctrine()->getManager();
		$userRepo = $em->getRepository("RigauxtUserBundle:User");
		$user = $userRepo->findOneBy(array("username" => $username));
		if($user == null)
			return $this->redirect($this->generateUrl("fos_user_profile_show"));
		return $this->render('FOSUserBundle:Profile:show.html.twig', array(
			"user" => $user
		));
	}
	
	public function removeAvatarAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			return $this->redirect($this->generateUrl("rigauxt_alumni_index"));
		}
		$user->preRemoveUpload();
		$user->removeUpload();
		return $this->redirect($this->generateUrl("fos_user_profile_show"));
	}
}
