<?php

namespace Gost\Bundle\SiteManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gost\Bundle\BaseBundle\Component\BaseEntity;


/**
 * 功能组对象数据实体类
 * 
 * @author devy
 *        
 * @ORM\Entity(repositoryClass="Gost\Bundle\SiteManagerBundle\Repository\MFuncGroupRepository")
 * @ORM\Table(name="m_func_group")
 */
class MFuncGroup extends BaseEntity {

	const TABLE_NAME = 'm_func_group';

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="MFuncGroup")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
	 *
	 * @var MFuncGroup|null 父级
	 */
	private $parent;

	/**
	 * @ORM\Column(name="group_title", type="string")
	 *
	 * @var string 标题
	 */
	private $title;
	
	/**
	 * @ORM\Column(name="group_key", type="string", unique=true)
	 *
	 * @var string Key
	 */
	private $key;
	
	/**
	 * @ORM\OneToMany(targetEntity="MFunc", mappedBy="group")
	 * @ORM\OrderBy({"sortNo" = "ASC"})
	 *
	 * @var ArrayCollection 包含功能(MFunc)
	 */
	private $functions;

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
        $this->functions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return MFuncGroup
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
     * @return MFuncGroup
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
     * Set sortNo
     *
     * @param integer $sortNo
     * @return MFuncGroup
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
     * Set parent
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup $parent
     * @return MFuncGroup
     */
    public function setParent(\Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add functions
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MFunc $functions
     * @return MFuncGroup
     */
    public function addFunction(\Gost\Bundle\SiteManagerBundle\Entity\MFunc $functions)
    {
        $this->functions[] = $functions;

        return $this;
    }

    /**
     * Remove functions
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MFunc $functions
     */
    public function removeFunction(\Gost\Bundle\SiteManagerBundle\Entity\MFunc $functions)
    {
        $this->functions->removeElement($functions);
    }

    /**
     * Get functions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFunctions()
    {
        return $this->functions;
    }
}
