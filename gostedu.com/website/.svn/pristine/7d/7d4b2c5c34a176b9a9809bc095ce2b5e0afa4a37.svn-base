<?php
namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="gst_advisory")
*/
class Advisory {

	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="name", type="string", length=20)
	 */
	protected $name;

	/**
	 * @ORM\Column(name="school", type="string", length=40)
	 */
	protected $school;

	/**
	 * @ORM\Column(name="major", type="string", length=50)
	 */
	protected $major;

	/**
	 * @ORM\Column(name="mobile", type="string", length=11)
	 */
	protected $mobile;

	/**
	 * @ORM\Column(name="sendtime", type="integer")
	 */
	protected $sendtime;

	/**
	 * @ORM\Column(name="advisory_time", type="integer")
	 */
	protected $advisory_time;

	/**
	 * @ORM\Column(name="remark", type="string", length=255)
	 */
	protected $remark;
}
