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
   * @ORM\JoinColumn(nullable=true)
   */
    private $trace;

    /**
   * @ORM\ManyToOne(targetEntity="ReceptionBundle\Entity\Reception", inversedBy="photos")
   * @ORM\JoinColumn(nullable=true)
   */
    private $reception;

    /**
     * @var string
     *
     * @Assert\NotNull(message="Sélectionnez une photo", groups={"new"})
     * @Assert\File(maxSize = "7M", mimeTypes = {"image/gif", "image/jpeg", "image/pjpeg", "image/png"})
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
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

    /**
     * Set reception
     *
     * @param \ReceptionBundle\Entity\Reception $reception
     *
     * @return Photo
     */
    public function setReception(\ReceptionBundle\Entity\Reception $reception = null)
    {
        $this->reception = $reception;

        return $this;
    }

    /**
     * Get reception
     *
     * @return \ReceptionBundle\Entity\Reception
     */
    public function getReception()
    {
        return $this->reception;
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


    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }
}
