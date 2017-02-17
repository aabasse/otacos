<?php

namespace TemperatureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReleveEquipement
 *
 * @ORM\Table(name="releve_equipement")
 * @ORM\Entity(repositoryClass="TemperatureBundle\Repository\ReleveEquipementRepository")
 */
class ReleveEquipement
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
   * @ORM\ManyToOne(targetEntity="TemperatureBundle\Entity\Releve")
   * @ORM\JoinColumn(nullable=false)
   */
    private $releve;

    /**
   * @ORM\ManyToOne(targetEntity="TemperatureBundle\Entity\Equipement")
   * @ORM\JoinColumn(nullable=false)
   */
    private $equipement;

    /**
     * @var string
     *
     * @ORM\Column(name="degre", type="string", length=255)
     */
    private $degre;


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
     * Set degre
     *
     * @param string $degre
     *
     * @return ReleveEquipement
     */
    public function setDegre($degre)
    {
        $this->degre = $degre;

        return $this;
    }

    /**
     * Get degre
     *
     * @return string
     */
    public function getDegre()
    {
        return $this->degre;
    }

    /**
     * Set releve
     *
     * @param \TemperatureBundle\Entity\Releve $releve
     *
     * @return ReleveEquipement
     */
    public function setReleve(\TemperatureBundle\Entity\Releve $releve)
    {
        $this->releve = $releve;

        return $this;
    }

    /**
     * Get releve
     *
     * @return \TemperatureBundle\Entity\Releve
     */
    public function getReleve()
    {
        return $this->releve;
    }

    /**
     * Set equipement
     *
     * @param \TemperatureBundle\Entity\Equipement $equipement
     *
     * @return ReleveEquipement
     */
    public function setEquipement(\TemperatureBundle\Entity\Equipement $equipement)
    {
        $this->equipement = $equipement;

        return $this;
    }

    /**
     * Get equipement
     *
     * @return \TemperatureBundle\Entity\Equipement
     */
    public function getEquipement()
    {
        return $this->equipement;
    }
}
