<?php
namespace Gost\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Entity
 * @ORM\Table(name="gst_news")
 */
class News {

	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="title", type="string", length=50)
	 */
	protected $title;

	/**
	 * @ORM\Column(name="sendtime", type="integer")
	 */
	protected $sendtime;

	/**
	 * @ORM\Column(name="content", type="text")
	 */
	protected $content;

	/**
	 * @ORM\Column(name="channel", type="integer")
     * @ORM\ManyToOne(targetEntity="Channel")
	 */
	protected $channel;

	/**
	 * @ORM\Column(name="source", type="string", length=30)
	 */
	protected $source;

	/**
	 * @ORM\Column(name="author", type="string", length=30)
	 */
	protected $author;

	/**
	 * @ORM\Column(name="thumbnail", type="string", length=100)
	 */
	protected $thumbnail;

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
     * @return News
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
     * Set sendtime
     *
     * @param integer $sendtime
     * @return News
     */
    public function setSendtime($sendtime)
    {
        $this->sendtime = $sendtime;

        return $this;
    }

    /**
     * Get sendtime
     *
     * @return integer 
     */
    public function getSendtime()
    {
        return $this->sendtime;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return News
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set channel
     *
     * @param integer $channel
     * @return News
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel
     *
     * @return integer 
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return News
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return News
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return News
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}
