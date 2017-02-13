<?php

namespace TracabiliteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trace
 *
 * @ORM\Table(name="trace")
 * @ORM\Entity(repositoryClass="TracabiliteBundle\Repository\TraceRepository")
 */
class Trace
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
   * @ORM\ManyToOne(targetEntity="TracabiliteBundle\Entity\Element")
   * @ORM\JoinColumn(nullable=true)
   */
    private $element;

    /**
   * @ORM\OneToMany(targetEntity="TracabiliteBundle\Entity\Photo", mappedBy="trace", cascade={"persist", "remove"})
   * @ORM\JoinColumn(nullable=true)
    * @Assert\Count(
    *      min = 1,
    *      max = 3,
    *      minMessage = "Au moin une photo est nécessaire.",
    *      maxMessage = "Vous ne pouvez pas envoyer plus de {{ limit }} photos."
    * )
   * @Assert\Valid()
   */
    private $photos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Trace
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     *
     * @return Trace
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string
     */
    public function getRemarque()
    {
        return $this->remarque;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set element
     *
     * @param \TracabiliteBundle\Entity\Element $element
     *
     * @return Trace
     */
    public function setElement(\TracabiliteBundle\Entity\Element $element = null)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get element
     *
     * @return \TracabiliteBundle\Entity\Element
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Add photo
     *
     * @param \TracabiliteBundle\Entity\Photo $photo
     *
     * @return Trace
     */
    public function addPhoto(\TracabiliteBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;
        $photo->setTrace($this);

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \TracabiliteBundle\Entity\Photo $photo
     */
    public function removePhoto(\TracabiliteBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
