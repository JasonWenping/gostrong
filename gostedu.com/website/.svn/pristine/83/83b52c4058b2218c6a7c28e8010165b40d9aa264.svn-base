<?php

namespace Gost\Bundle\SiteManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 后台功能操作对象实体类
 *
 * @author devy
 *        
 * @ORM\Entity
 * @ORM\Table(name="m_action")
 */
class MAction extends BaseEntity {

	const TABLE_NAME = 'm_action';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="MFunc", inversedBy="actions")
	 * @ORM\JoinColumn(name="func_id", referencedColumnName="id")
	 *
	 * @var MFunc 所属功能
	 */
	private $func;
	
	/**
	 * @ORM\Column(name="action_title", type="string")
	 *
	 * @var string 操作名称
	 */
	private $title;
	
	/**
	 * @ORM\Column(name="action_code", type="integer")
	 *
	 * @var integer 代码
	 */
	private $code;

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
     * @return MAction
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
     * Set code
     *
     * @param integer $code
     * @return MAction
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set func
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MFunc $func
     * @return MAction
     */
    public function setFunc(\Gost\Bundle\SiteManagerBundle\Entity\MFunc $func = null)
    {
        $this->func = $func;

        return $this;
    }

    /**
     * Get func
     *
     * @return \Gost\Bundle\SiteManagerBundle\Entity\MFunc 
     */
    public function getFunc()
    {
        return $this->func;
    }
}
