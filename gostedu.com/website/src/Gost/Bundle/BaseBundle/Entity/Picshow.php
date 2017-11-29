<?php
namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="gst_picshow")
*/
class Picshow {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="image", type="string", length=100)
	 */
	protected $image;

	/**
	 * @ORM\Column(name="url", type="string", length=255)
	 */
	protected $url;

	/**
	 * @ORM\Column(name="weight", type="integer")
	 */
	protected $weight;
}
