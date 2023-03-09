<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\AppelOffre;

/**
 * ReponseOffre
 *
 * @ORM\Table(name="reponse_offre", indexes={@ORM\Index(name="fk8", columns={"id_offre"})})
 * @ORM\Entity
 */
class ReponseOffre
{
    /**
     * @var int
     *@Groups({"groups", "Reponse"})
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *@Groups({"groups", "Reponse"})
     * @ORM\Column(name="nom_produit", type="string", length=255, nullable=false)
     */
    private $nomProduit;

    /**
     * @Assert\NotBlank(message=" budget  est obligatoire")
     * @Assert\Type(type="float")
     * @var float
     *@Groups({"groups", "Reponse"})
     * @ORM\Column(name="budget", type="float", precision=10, scale=0, nullable=false)
     */
    private $budget;

    /**
     * @Assert\NotBlank(message=" etat  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Reponse"})
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \DateTime
     *@Groups({"groups", "Reponse"})
     * @ORM\Column(name="date", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \AppelOffre
     * @ORM\ManyToOne(targetEntity="AppelOffre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_offre", referencedColumnName="id")
     * })
     */
    private $idOffre;


   /**
     * @var int
     *@Groups({"groups", "Reponse"})
     */
    private $idof;

    public function getidof(): ?int
    {
        return $this->idOffre->getId();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function nom_produit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

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

    public function getIdOffre(): ?AppelOffre
    {
        return $this->idOffre;
    }

    public function id_offre(): ?AppelOffre
    {
        return $this->idOffre;
    }

    public function setIdOffre(?AppelOffre $idOffre): self
    {
        $this->idOffre = $idOffre;

        return $this;
    }


}
