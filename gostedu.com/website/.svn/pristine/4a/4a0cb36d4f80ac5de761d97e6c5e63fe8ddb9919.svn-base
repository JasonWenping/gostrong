<?php

namespace Gost\Bundle\SiteManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Security\Core\User\UserInterface;

use Gost\Bundle\BaseBundle\Component\BaseEntity;

/**
 * 后台用户对象实体类
 *
 * @author devy
 *        
 * @ORM\Entity(repositoryClass="Gost\Bundle\SiteManagerBundle\Repository\MUserRepository")
 * @ORM\Table(name="m_user")
 */
class MUser extends BaseEntity implements UserInterface {

	const TABLE_NAME = 'm_user';
	const USER_ROLE_TABLE_NAME = 'm_user_role';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var integer ID
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", unique=true)
	 *
	 * @var string 用户名
	 */
	private $username;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 *
	 * @var string 密码
	 */
	private $password;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 *
	 * @var string 密钥
	 */
	private $salt;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 *
	 * @var string 电子邮件
	 */
	private $email;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 *
	 * @var string 电话号码
	 */
	protected $tel;
	
	/**
	 * @ORM\Column(type="integer", name="created_at")
	 *
	 * @var integer 创建于
	 */
	protected $createdAt;

	/**
	 * @ORM\Column(type="integer", name="last_update_at", nullable=true)
	 *
	 * @var integer 最后更新于(时间戳)
	 */
	protected $lastUpdateAt;
	
	/**
	 * @ORM\Column(type="boolean", name="is_blocked")
	 *
	 * @var boolean 帐号是否被阻止
	 */
	protected $isBlocked = false;
	
	/**
	 * @ORM\Column(type="string", name="fullname", nullable=true)
	 *
	 * @var string 姓名
	 */
	protected $fullname;
	
	/**
	 * @ORM\Column(type="string", name="gender", length=1, nullable=true)
	 *
	 * @var string 性别
	 */
	protected $gender;
	
	/**
	 * @ORM\Column(type="string", name="birthdate", length=10, nullable=true)
	 *
	 * @var string 出生日期
	 */
	protected $birthdate;
	
	
	/**
	 * @ORM\ManyToMany(targetEntity="MRole")
	 * @ORM\JoinTable(name="m_user_role",
	 *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
	 * )
	 *
	 * @var ArrayCollection 所属角色
	 */
	protected $userRoles;
	
	/**
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
	 */
	public function getRoles() {
		$roles = array();
		foreach ($this->userRoles as $role) {
			$roles[] = new \Symfony\Component\Security\Core\Role\Role($role->getRole());
		}
		return $roles;
		//return $this->getUserRoles()->toArray();
	}
	/**
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getPassword()
	 */
	public function getPassword() {
		return $this->password;
	}
	/**
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
	 */
	public function getSalt() {
		return $this->salt;
	}
	/**
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
	 */
	public function getUsername() {
		return $this->username;
	}
	/**
	 * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
	 */
	public function eraseCredentials() {
		return $this;
	}
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userRoles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return MUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return MUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return MUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return MUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return MUser
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set createdAt
     *
     * @param integer $createdAt
     * @return MUser
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return integer 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set lastUpdateAt
     *
     * @param integer $lastUpdateAt
     * @return MUser
     */
    public function setLastUpdateAt($lastUpdateAt)
    {
        $this->lastUpdateAt = $lastUpdateAt;

        return $this;
    }

    /**
     * Get lastUpdateAt
     *
     * @return integer 
     */
    public function getLastUpdateAt()
    {
        return $this->lastUpdateAt;
    }

    /**
     * Set isBlocked
     *
     * @param boolean $isBlocked
     * @return MUser
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * Get isBlocked
     *
     * @return boolean 
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return MUser
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return MUser
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthdate
     *
     * @param string $birthdate
     * @return MUser
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return string 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Add userRoles
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MRole $userRoles
     * @return MUser
     */
    public function addUserRole(\Gost\Bundle\SiteManagerBundle\Entity\MRole $userRoles)
    {
        $this->userRoles[] = $userRoles;

        return $this;
    }

    /**
     * Remove userRoles
     *
     * @param \Gost\Bundle\SiteManagerBundle\Entity\MRole $userRoles
     */
    public function removeUserRole(\Gost\Bundle\SiteManagerBundle\Entity\MRole $userRoles)
    {
        $this->userRoles->removeElement($userRoles);
    }

    /**
     * Get userRoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }
}
