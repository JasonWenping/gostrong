<?php

namespace Gost\Bundle\SiteManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 权限对象实体类
 * 
 * @author devy
 *
 * @ORM\Entity(repositoryClass="Gost\Bundle\SiteManagerBundle\Repository\MPermissionRepository")
 * @ORM\Table(name="m_permission", uniqueConstraints={
 * @ORM\UniqueConstraint(name="m_permission_unique", columns={"target_type", "target_id", "func_id", "data_scope"})})
 */
class MPermission extends BaseEntity {

	const TABLE_NAME = 'm_permission';
	
	/**
	 * @var integer 对象类型 - 用户
	 */
	const TARGET_TYPE_USER = 0;
	
	/**
	 * @var integer 对象类型 - 角色
	 */
	const TARGET_TYPE_ROLE = 1;
	
	/**
	 * @var integer 范围 - 个人
	 */
	const SCOPE_PERSONAL = 0;
	
	/**
	 * @var integer 范围 - 全局
	 */
	const SCOPE_GLOBAL = 1;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	private $id;
	
	/**
	 * @ORM\Column(name="target_id", type="integer")
	 *
	 * @var integer 对象ID(用户或角色)
	 */
	private $targetId;
	
	/**
	 * @ORM\Column(name="target_type", type="integer")
	 *
	 * @var integer 对象类型
	 */
	private $targetType;
	
	/**
	 * @ORM\ManyToOne(targetEntity="MFunc")
	 * @ORM\JoinColumn(name="func_id", referencedColumnName="id")
	 *
	 * @var MFunc 功能
	 */
	private $function;
	
	/**
	 * @ORM\Column(name="perm_code", type="integer")
	 *
	 * @var integer 权限码
	 */
	private $permissions;
	
	/**
	 * @ORM\Column(name="data_scope", type="integer")
	 *
	 * @var integer 范围(全局/个人)
	 */
	private $scope = 0;

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
     * Set targetId
     *
     * @param integer $targetId
     * @return MPermission
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;

        return $this;
    }

    /**
     * Get targetId
     *
     * @return integer 
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * Set targetType
     *
     * @param integer $targetType
     * @return MPermission
     */
    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;

        return $this;
    }

    /**
     * Get targetType
     *
     * @return integer 
     */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
     * Set permissions
     *
     * @param integer $permissions
     * @return MPermission
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Get permissions
     *
     * @return integer 
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Set scope
     *
     * @param integer $scope
     * @return MPermission
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return integer 
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set function
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MFunc $function
     * @return MPermission
     */
    public function setFunction(\Gost\Bundle\SiteManagerBundle\Entity\MFunc $function = null)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return \Gost\Bundle\SiteManagerBundle\Entity\MFunc 
     */
    public function getFunction()
    {
        return $this->function;
    }
}
