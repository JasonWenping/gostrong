<?php
namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="gst_announcement")
*/
class Announcement {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=60)
     */
    protected $title;

	/**
	 * @ORM\Column(name="keywords", type="string", length=60)
	 */
	protected $keywords;

	/**
	 * @ORM\Column(name="content", type="text")
	 */
	protected $content;

	/**
	 * @ORM\Column(name="author", type="string", length=30)
	 */
	protected $author;

	/**
	 * @ORM\Column(name="sendtime", type="integer")
	 */
	protected $sendtime;
}
