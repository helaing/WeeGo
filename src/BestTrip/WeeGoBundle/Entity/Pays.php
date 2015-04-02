<?php

namespace BestTrip\WeeGoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * @ORM\Entity
 */
class Pays
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_p", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idP;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_pays", type="string", length=50, nullable=false)
     */
    private $nomPays;

    /**
     * @var string
     *
     * @ORM\Column(name="continent", type="string", length=50, nullable=false)
     */
    private $continent;

    /**
     * @var string
     *
     * @ORM\Column(name="capitale", type="string", length=20, nullable=false)
     */
    private $capitale;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=15, nullable=false)
     */
    private $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="monnaie", type="string", length=10, nullable=false)
     */
    private $monnaie;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_habitant", type="integer", nullable=false)
     */
    private $nbHabitant;


}
