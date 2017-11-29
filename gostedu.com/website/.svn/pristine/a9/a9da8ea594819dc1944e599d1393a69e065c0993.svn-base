<?php

namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 网站导航实体类
 *
 * @ORM\Entity(repositoryClass="Gost\Bundle\BaseBundle\Repository\NavigationRepository")
 * @ORM\Table(name="gst_navigation")
 * 
 * @author devylee
 *        
 */
class Navigation extends BaseEntity {

	const TABLE_NAME = 'gst_navigation';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	protected $id;
	
	/**
	 * @ORM\Column(name="nav_key", type="string", unique=true)
	 *
	 * @var string 导航菜单关键字
	 */
	protected $key;
	
	/**
	 * @ORM\Column(name="nav_name", type="string")
	 *
	 * @var string 导航位名称
	 */
	protected $name;
	
	/**
	 * @ORM\OneToMany(targetEntity="NavigationMenu", mappedBy="navigation")
	 * @ORM\OrderBy({"id" = "ASC"})
	 *
	 * @var ArrayCollection  导航菜单
	 */
	protected $menus;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set key
     *
     * @param string $key
     * @return Navigation
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Navigation
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
     * Add menus
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenu $menus
     * @return Navigation
     */
    public function addMenu(\Gost\Bundle\BaseBundle\Entity\NavigationMenu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenu $menus
     */
    public function removeMenu(\Gost\Bundle\BaseBundle\Entity\NavigationMenu $menus)
    {
        $this->menus->removeElement($menus);
    }

    /**
     * Get menus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMenus()
    {
        return $this->menus;
    }
}
