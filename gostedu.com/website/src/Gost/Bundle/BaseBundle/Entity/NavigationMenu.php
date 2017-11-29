<?php

namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 网站导航菜单实体类
 *
 * @ORM\Entity(repositoryClass="Gost\Bundle\BaseBundle\Repository\NavigationMenuRepository")
 * @ORM\Table(name="gst_navigation_menu")
 * 
 * @author devylee
 *        
 */
class NavigationMenu extends BaseEntity {

	const TABLE_NAME = 'gst_navigation_menu';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Navigation", inversedBy="menus")
	 * @ORM\JoinColumn(name="navigation_id", referencedColumnName="id", nullable=true)
	 *
	 * @var Navigation|null 导航栏位
	 */
	protected $navigation;
	
	/**
	 * @ORM\Column(name="nav_key", type="string", unique=true)
	 *
	 * @var string 导航菜单关键字
	 */
	protected $key;
	
	/**
	 * @ORM\Column(name="nav_name", type="string")
	 *
	 * @var string 导航菜单名称
	 */
	protected $name;
	
	/**
	 * @ORM\Column(name="is_top_menu", type="boolean")
	 *
	 * @var boolean 是否是根菜单
	 */
	protected $isTopMenu = true;
	
	/**
	 * @ORM\ManyToOne(targetEntity="NavigationMenu", inversedBy="submenus")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
	 *
	 * @var Region|null 父菜单
	 */
	protected $parent;
	
	/**
	 * @ORM\OneToMany(targetEntity="NavigationMenu", mappedBy="parent")
	 * @ORM\OrderBy({"sort" = "ASC","id" = "ASC"})
	 *
	 * @var ArrayCollection 下设菜单
	 */
	protected $submenus;
	
	/**
	 * @ORM\OneToMany(targetEntity="NavigationMenuParameter", mappedBy="menu")
	 * @ORM\OrderBy({"id" = "ASC"})
	 *
	 * @var ArrayCollection 下设参数
	 */
	protected $parameters;
	
	/**
	 * @ORM\Column(name="nav_sort", type="integer", nullable=true)
	 *
	 * @var interger  排序
	 */
	protected $sort = 0;
	
	/**
	 *  @ORM\Column(name="menu_type", type="integer")
	 *
	 * @var interger 栏目类别
	 */
	protected $menuType = 0;
	
	/**
	 * @ORM\Column(name="nav_router", type="string")
	 *
	 * @var string 导航菜单路由
	 */
	protected $router;
	
	/**
	 * @ORM\Column(name="is_open_blank",type="boolean")
	 *
	 * @var boolean 是否在新窗口打开
	 */
	protected $isOpenBlank = false;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->submenus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parameters = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return NavigationMenu
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
     * @return NavigationMenu
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
     * Set isTopMenu
     *
     * @param boolean $isTopMenu
     * @return NavigationMenu
     */
    public function setIsTopMenu($isTopMenu)
    {
        $this->isTopMenu = $isTopMenu;

        return $this;
    }

    /**
     * Get isTopMenu
     *
     * @return boolean 
     */
    public function getIsTopMenu()
    {
        return $this->isTopMenu;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return NavigationMenu
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set menuType
     *
     * @param integer $menuType
     * @return NavigationMenu
     */
    public function setMenuType($menuType)
    {
        $this->menuType = $menuType;

        return $this;
    }

    /**
     * Get menuType
     *
     * @return integer 
     */
    public function getMenuType()
    {
        return $this->menuType;
    }

    /**
     * Set router
     *
     * @param string $router
     * @return NavigationMenu
     */
    public function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Get router
     *
     * @return string 
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Set isOpenBlank
     *
     * @param boolean $isOpenBlank
     * @return NavigationMenu
     */
    public function setIsOpenBlank($isOpenBlank)
    {
        $this->isOpenBlank = $isOpenBlank;

        return $this;
    }

    /**
     * Get isOpenBlank
     *
     * @return boolean 
     */
    public function getIsOpenBlank()
    {
        return $this->isOpenBlank;
    }

    /**
     * Set navigation
     *
     * @param \Gost\Bundle\BaseBundle\Entity\Navigation $navigation
     * @return NavigationMenu
     */
    public function setNavigation(\Gost\Bundle\BaseBundle\Entity\Navigation $navigation = null)
    {
        $this->navigation = $navigation;

        return $this;
    }

    /**
     * Get navigation
     *
     * @return \Gost\Bundle\BaseBundle\Entity\Navigation 
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * Set parent
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenu $parent
     * @return NavigationMenu
     */
    public function setParent(\Gost\Bundle\BaseBundle\Entity\NavigationMenu $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Gost\Bundle\BaseBundle\Entity\NavigationMenu 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add submenus
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenu $submenus
     * @return NavigationMenu
     */
    public function addSubmenu(\Gost\Bundle\BaseBundle\Entity\NavigationMenu $submenus)
    {
        $this->submenus[] = $submenus;

        return $this;
    }

    /**
     * Remove submenus
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenu $submenus
     */
    public function removeSubmenu(\Gost\Bundle\BaseBundle\Entity\NavigationMenu $submenus)
    {
        $this->submenus->removeElement($submenus);
    }

    /**
     * Get submenus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubmenus()
    {
        return $this->submenus;
    }

    /**
     * Add parameters
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenuParameter $parameters
     * @return NavigationMenu
     */
    public function addParameter(\Gost\Bundle\BaseBundle\Entity\NavigationMenuParameter $parameters)
    {
        $this->parameters[] = $parameters;

        return $this;
    }

    /**
     * Remove parameters
     *
     * @param \Gost\Bundle\BaseBundle\Entity\NavigationMenuParameter $parameters
     */
    public function removeParameter(\Gost\Bundle\BaseBundle\Entity\NavigationMenuParameter $parameters)
    {
        $this->parameters->removeElement($parameters);
    }

    /**
     * Get parameters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
