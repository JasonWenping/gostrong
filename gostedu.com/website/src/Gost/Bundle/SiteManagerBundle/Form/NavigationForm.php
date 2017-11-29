<?php

namespace Gost\Bundle\SiteManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 导航表单类
 *
 * @author devylee
 *        
 */
class NavigationForm extends AbstractType {
	
	/**
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return 'navigation_form';
	}
	
	/**
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('id', 'hidden')
                ->add('key', 'text', array('required' => true, 'max_length' => 32))
                ->add('name', 'text', array('required' => true, 'max_length' => 32));
	}
}