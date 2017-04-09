<?php

namespace TemperatureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Degre
 *
 * @ORM\Table(name="degre")
 * @ORM\Entity(repositoryClass="TemperatureBundle\Repository\DegreRepository")
 */
class Degre
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
   * @ORM\ManyToOne(targetEntity="TemperatureBundle\Entity\Releve", inversedBy="degres")
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
     * @ORM\Column(name="valeur", type="string", length=255)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     message="ca doit etre un nombre"
     * )
     */
    private $valeur;


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
     * Set valeur
     *
     * @param string $valeur
     *
     * @return Degre
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set releve
     *
     * @param \TemperatureBundle\Entity\Releve $releve
     *
     * @return Degre
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
     * @return Degre
     */
    public function setEquipement(\TemperatureBundle\Entity\Equipement $equipement = null)
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
