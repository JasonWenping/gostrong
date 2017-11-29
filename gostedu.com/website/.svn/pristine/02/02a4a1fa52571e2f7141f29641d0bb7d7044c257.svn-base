<?php

namespace Gost\Bundle\SiteManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\Role\RoleInterface;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 角色对象实体类
 *
 * @author devy
 *       
 * @ORM\Entity(repositoryClass="Gost\Bundle\SiteManagerBundle\Repository\MRoleRepository")
 * @ORM\Table(name="m_role") 
 */
class MRole extends BaseEntity implements RoleInterface {

	const TABLE_NAME = 'm_role';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", name="role_name", unique=true)
	 *
	 * @var string 角色名称
	 */
	private $name;
	
	function __construct($name = null) {
		$this->name = $name;
	}
	
	/**
	 * @see \Symfony\Component\Security\Core\Role\RoleInterface::getRole()
	 */
	public function getRole() {
		return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return MRole
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
}
