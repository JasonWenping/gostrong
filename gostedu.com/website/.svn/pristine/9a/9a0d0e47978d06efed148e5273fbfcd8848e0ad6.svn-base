<?php
namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="gst_cooperator")
*/
class Cooperator {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @ORM\Column(name="type", type="integer")
     * @ORM\ManyToOne(targetEntity="Cootype")
     */
    protected $type;

	/**
	 * @ORM\Column(name="name", type="string", length=40)
	 */
	protected $name;

	/**
	 * @ORM\Column(name="logo", type="string", length=255)
	 */
	protected $logo;

    /**
     * @ORM\Column(name="website", type="string", length=100)
     */
    protected $website;

    /**
     * @ORM\Column(name="introduction", type="string", length=255)
     */
    protected $introduction;
}
