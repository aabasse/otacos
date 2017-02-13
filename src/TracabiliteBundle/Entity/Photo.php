<?php

namespace TracabiliteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="TracabiliteBundle\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
   * @ORM\ManyToOne(targetEntity="TracabiliteBundle\Entity\Trace", inversedBy="photos")
   * @ORM\JoinColumn(nullable=false)
   */
    private $trace;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\NotNull(message="Sélectionnez une photo")
     * @Assert\File(maxSize = "7M", mimeTypes = {"image/gif", "image/jpeg", "image/pjpeg", "image/png"})
     */
    private $url;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set url
     *
     * @param string $url
     *
     * @return Photo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set trace
     *
     * @param \TracabiliteBundle\Entity\Trace $trace
     *
     * @return Photo
     */
    public function setTrace(\TracabiliteBundle\Entity\Trace $trace = null)
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * Get trace
     *
     * @return \TracabiliteBundle\Entity\Trace
     */
    public function getTrace()
    {
        return $this->trace;
    }
}
