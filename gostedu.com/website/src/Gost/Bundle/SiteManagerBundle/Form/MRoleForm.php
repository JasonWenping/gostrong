<?php

namespace Gost\Bundle\SiteManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *
 * @author devylee
 *        
 */
class MRoleForm extends AbstractType {
	
	/**
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return 'form_mrole';
	}
	
	
	/**
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('id', 'hidden')
				->add('name', 'text', array('required'=>true, 'max_length'=>32));
	}

}