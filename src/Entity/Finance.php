<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Finance
 *
 * @ORM\Table(name="finance", indexes={@ORM\Index(name="fk3", columns={"id_facture"})})
 * @ORM\Entity
 */
class Finance
{
    /** 
     * @var int
     * @Groups("finance")

     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     * @Groups("finance")
     * @Assert\NotBlank(message=" taxe   est obligatoire")
     * @Assert\Type(type="float")
     * @ORM\Column(name="taxe", type="float", precision=10, scale=0, nullable=false)
     */
    private $taxe;

    /**
     * @var int
     * @Groups("finance")
     * @Assert\NotBlank(message=" tva   est obligatoire")
     * @Assert\Type(type="integer")
     * @ORM\Column(name="tva", type="integer", nullable=false)
     */
    private $tva;

    /**
     * @var string
     * @Groups("finance")
     * @Assert\NotBlank(message=" photo   est obligatoire")
     * @Assert\Type(type="string")
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var float
     * @Groups("finance")
     * @Assert\NotBlank(message=" prix   est obligatoire")
     * @Assert\Type(type="float")
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     * @Groups("finance")
     * @Assert\NotBlank(message=" etat   est obligatoire")
     * @Assert\Type(type="string")
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \DateTime
     * @Groups("finance")
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Facture
     * @Groups("finance")
     * @ORM\ManyToOne(targetEntity="Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_facture", referencedColumnName="id_facture")
     * })
     */
    private $idFacture;

     /**
     * @var int
     * @Groups("finance")
     * 
     */   
    private $ide;
    

    public function getId(): ?int
    {
        return $this->id;
    }

  
    public function getide(): ?int
    {
        return $this->idFacture->getIdFacture();
    }
    public function getTaxe(): ?float
    {
        return $this->taxe;
    }

    public function setTaxe(float $taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdFacture(): ?Facture
    {
        return $this->idFacture;
    }
    public function id_facture(): ?Facture
    {
        return $this->idFacture;
    }

    public function setIdFacture(?Facture $idFacture): self
    {
        $this->idFacture = $idFacture;

        return $this;
    }


}
