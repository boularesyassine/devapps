<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicite
 *
 * @ORM\Table(name="publicite", indexes={@ORM\Index(name="fk6", columns={"id_sponsor"})})
 * @ORM\Entity
 */
class Publicite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_pub", type="string", length=255, nullable=false)
     */
    private $nomPub;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \Sponsor
     *
     * @ORM\ManyToOne(targetEntity="Sponsor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sponsor", referencedColumnName="id")
     * })
     */
    private $idSponsor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPub(): ?string
    {
        return $this->nomPub;
    }

    public function setNomPub(string $nomPub): self
    {
        $this->nomPub = $nomPub;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdSponsor(): ?Sponsor
    {
        return $this->idSponsor;
    }

    public function setIdSponsor(?Sponsor $idSponsor): self
    {
        $this->idSponsor = $idSponsor;

        return $this;
    }


}
