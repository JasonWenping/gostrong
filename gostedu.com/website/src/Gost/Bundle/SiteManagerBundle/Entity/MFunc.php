<?php

namespace Gost\Bundle\SiteManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 后台功能对象实体类
 *
 * @author devy
 *        
 * @ORM\Entity(repositoryClass="Gost\Bundle\SiteManagerBundle\Repository\MFuncRepository")
 * @ORM\Table(name="m_func")
 */
class MFunc extends BaseEntity {

	const TABLE_NAME = 'm_func';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="MFuncGroup", inversedBy="functions")
	 * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
	 *
	 * @var MFuncGroup 所属组
	 */
	private $group;
	
	/**
	 * @ORM\Column(name="func_title", type="string")
	 *
	 * @var string 标题
	 */
	private $title;
	
	/**
	 * @ORM\Column(name="func_key", type="string", unique=true)
	 *
	 * @var string Key
	 */
	private $key;
	
	/**
	 * @ORM\Column(name="page_route", type="string", nullable=true)
	 *
	 * @var string 路由
	 */
	private $route;
	
	/**
	 * @ORM\OneToMany(targetEntity="MAction", mappedBy="func")
	 * @ORM\OrderBy({"code"="ASC"})
	 *
	 * @var ArrayCollection 包含操作(MAction)
	 */
	private $actions;
	
	/**
	 * @ORM\Column(name="is_menu_item", type="boolean")
	 *
	 * @var boolean 是否是菜单项(菜单项将会在菜单列表中显示)
	 */
	private $isMenuItem = true;
	
	/**
	 * @ORM\Column(name="sort_no", type="integer")
	 *
	 * @var integer 序号
	 */
	private $sortNo = 0;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return MFunc
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return MFunc
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
     * Set route
     *
     * @param string $route
     * @return MFunc
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set isMenuItem
     *
     * @param boolean $isMenuItem
     * @return MFunc
     */
    public function setIsMenuItem($isMenuItem)
    {
        $this->isMenuItem = $isMenuItem;

        return $this;
    }

    /**
     * Get isMenuItem
     *
     * @return boolean 
     */
    public function getIsMenuItem()
    {
        return $this->isMenuItem;
    }

    /**
     * Set sortNo
     *
     * @param integer $sortNo
     * @return MFunc
     */
    public function setSortNo($sortNo)
    {
        $this->sortNo = $sortNo;

        return $this;
    }

    /**
     * Get sortNo
     *
     * @return integer 
     */
    public function getSortNo()
    {
        return $this->sortNo;
    }

    /**
     * Set group
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup $group
     * @return MFunc
     */
    public function setGroup(\Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add actions
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MAction $actions
     * @return MFunc
     */
    public function addAction(\Gost\Bundle\SiteManagerBundle\Entity\MAction $actions)
    {
        $this->actions[] = $actions;

        return $this;
    }

    /**
     * Remove actions
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MAction $actions
     */
    public function removeAction(\Gost\Bundle\SiteManagerBundle\Entity\MAction $actions)
    {
        $this->actions->removeElement($actions);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActions()
    {
        return $this->actions;
    }
}
