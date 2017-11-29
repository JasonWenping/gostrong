<?php

namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 导航菜单参数实体类
 *
 * @ORM\Entity(repositoryClass="Gost\Bundle\BaseBundle\Repository\NavigationMenuParameterRepository")
 * @ORM\Table(name="gst_navigation_menu_parameter")
 * 
 * @author devylee
 *        
 */
class NavigationMenuParameter extends BaseEntity {

	const TABLE_NAME = 'gst_navigation_menu_parameter';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="NavigationMenu", inversedBy="parameters")
	 * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", nullable=true)
	 *
	 * @var NavigationMenu|null 父菜单
	 */
	protected $menu;
	
	/**
	 * @ORM\Column(name="parameter_name", type="string")
	 *
	 * @var string 参数名称
	 */
	protected $name;
	
	/**
	 * @ORM\Column(name="parameter_value", type="string")
	 *
	 * @var string 参数值
	 */
	protected $value;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return NavigationMenuParameter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return NavigationMenuParameter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set menu
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenu $menu
     * @return NavigationMenuParameter
     */
    public function setMenu(\Gost\Bundle\BaseBundle\Entity\NavigationMenu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Gost\Bundle\BaseBundle\Entity\NavigationMenu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
