<?php

namespace Rigauxt\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rigauxt\ForumBundle\Entity\Categorie;
use Rigauxt\ForumBundle\Form\CategorieType;
use Rigauxt\ForumBundle\Entity\Post;
use Rigauxt\ForumBundle\Entity\Topic;
use Rigauxt\ForumBundle\Form\TopicType;

class CategoryController extends Controller
{
    public function addAction($slug)
    {
		$user = $this->container->get('security.context')->getToken()->getUser();
		if(!$this->get('security.context')->isGranted('ROLE_ADMIN'))
		{
			return $this->redirect($this->generateUrl("rigauxt_forum_index", array("slugPere" => $slug)));
		}
    	$em = $this->getDoctrine()->getManager();
    	$categoryRepo = $em->getRepository("RigauxtForumBundle:Categorie");
    	$category = $categoryRepo->findOneBy(array("slug" => $slug));
    	
    	$newCategory = new Categorie();
    	$form = $this->createForm(new CategorieType($category), $newCategory);
    	
		$request = $this->get('request');
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);

			if ($form->isValid())
			{
				$em->persist($newCategory);
				$em->flush();
	
				return $this->redirect($this->generateUrl("rigauxt_forum_index", array("slugPere" => $slug)));
			}
		}

        return $this->render('RigauxtForumBundle:Category:addCategory.html.twig', array(
        	"form"	=> $form->createView(),
        	"slug"	=> $slug,
        ));
    }
    public function removeAction($slug)
    {
    	$em = $this->getDoctrine()->getManager();
    	$categoryRepo = $em->getRepository("RigauxtForumBundle:Categorie");
    	$category = $categoryRepo->findOneBy(array("slug" => $slug));
    	
    	if($category == null)
    	{
			return $this->redirect($this->generateUrl("rigauxt_forum_index"));
    	}
    	
    	$container = $category->getPere();
    	if($container != null)	$slugContainer = $container->getSlug();
    	else $slugContainer = null;
    	
		$user = $this->container->get('security.context')->getToken()->getUser();
		if(!$this->get('security.context')->isGranted('ROLE_ADMIN'))
		{
			return $this->redirect($this->generateUrl("rigauxt_forum_index", array("slugPere" => $slug)));
		}
    	
    	$em->remove($category);
    	$em->flush();
    	
        return $this->redirect($this->generateUrl("rigauxt_forum_index", array("slugPere" => $slugContainer)));
    }
}
