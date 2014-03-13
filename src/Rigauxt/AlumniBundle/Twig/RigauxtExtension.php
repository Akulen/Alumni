<?php

namespace Rigauxt\AlumniBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class RigauxtExtension extends \Twig_Extension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

	public function getFunctions()
	{
		return array(
			'asset_if'	=> new \Twig_Function_Method($this, 'asset_if'),
			'format_avatar'	=> new \Twig_Function_Method($this, 'format_avatar', array('is_safe' => array('html'))),
		);
	}

	public function asset_if($path)
    {
        // Define the path to look for
        $pathToCheck = realpath($this->container->get('kernel')->getRootDir() . '/../web/') . '/' . $path;

        // If the path does not exist, return the fallback image
        if (!file_exists($pathToCheck))
        {
            return $this->container->get('templating.helper.assets')->getUrl("uploads/images/avatars/default.png");
        }

        // Return the real image
        return $this->container->get('templating.helper.assets')->getUrl($path);
    }
	
	public function format_avatar($user, $size)
	{
		$retour = "<img style='width: ".$size."px; height: auto";
		if($user->getMembre())
			$retour .= "; border: 1px solid #000";
		$retour .= "' src='".$this->asset_if($user->getWebPath())."' alt='".$user->getAvatarAlt()."' />";
		return $retour;
	}

	public function getName()
	{
		return 'rigauxt_extension';
	}
}
