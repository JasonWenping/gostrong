<?php

namespace Gost\Bundle\SiteManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 功能组表单类
 *
 * @author devylee
 *        
 */
class FuncgroupForm extends AbstractType {
	
	private $sort = array();
	private $register = true;
	
	function __construct($register = true, $groups = 0) {
		$this->register = $register;
		$groups = $register ? $groups + 1 : $groups;
		for ($i = 0; $i < $groups; $i ++) {
			$this->sort[$i] = $i;
		}
	}
	
	/**
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('id', 'hidden')
				->add('key', 'text', array('required'=>true, 'max_length'=>32, 'read_only'=>!$this->register))
				->add('title', 'text', array('required'=>true, 'max_length'=>32))
				->add('sort', 'choice', array('choices'=>$this->sort));
	}
	
	/**
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return 'form_funcgroup';
	}
	
}