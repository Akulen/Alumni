<?php

namespace Rigauxt\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategorieType extends AbstractType
{
	protected $defaultContainer;
	
	public function __construct($defaultContainer = null)
	{
		$this->defaultContainer = $defaultContainer;
	}
	
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('theme', 'entity', array(
				'class'				=> 'RigauxtForumBundle:Theme',
				'property'			=> 'name',
				'multiple'			=> false,
			))
		;
		if($this->defaultContainer != null)
			$builder->add('pere', 'entity', array(
						  'class'				=> 'RigauxtForumBundle:Categorie',
						  'property'			=> 'nom',
						  'multiple'			=> false,
						  'preferred_choices'	=> array($this->defaultContainer)
					));
		else
			$builder->add('pere', 'entity', array(
						  'class'				=> 'RigauxtForumBundle:Categorie',
						  'property'			=> 'nom',
						  'multiple'			=> false,
					));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rigauxt\ForumBundle\Entity\Categorie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rigauxt_forumbundle_categorie';
    }
}
