<?php

namespace Rigauxt\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rigauxt\ForumBundle\Entity\Type;

class TopicType extends AbstractType
{
	protected $categorie;
	protected $defaultType;
	
	public function __construct($categorie, $user, $defaultType)
	{
		$this->categorie = $categorie;
		$this->defaultType = $defaultType;
	}	
	
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add("categorie", "entity", array(
				'class'				=> 'RigauxtForumBundle:Categorie',
				'property'			=> 'nom',
				'multiple'			=> false,
				'preferred_choices'	=> array($this->categorie)
			))
			->add("title", "text", array(
				'attr'	=> array('placeHolder' => 'Titre'),
				'label'	=> 'Titre'
			))
			->add("type", "entity", array(
				'class'				=> 'RigauxtForumBundle:Type',
				'property'			=> 'name',
				'multiple'			=> false,
				'preferred_choices'	=> array($this->defaultType)
			))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rigauxt\ForumBundle\Entity\Topic',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rigauxt_forumbundle_topic';
    }
}
