<?php
namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="gst_activity")
*/
class Activity {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @ORM\Column(name="news", type="integer")
     * @ORM\OneToOne(targetEntity="News")
     */
    protected $news;

	/**
	 * @ORM\Column(name="aim", type="string", length=255)
	 */
	protected $aim;

	/**
	 * @ORM\Column(name="start_time", type="integer")
	 */
	protected $start_time;

    /**
     * @ORM\Column(name="temination_time", type="integer")
     */
    protected $temination_time;

    /**
     * @ORM\Column(name="rule", type="string", length=255)
     */
    protected $rule;
}
