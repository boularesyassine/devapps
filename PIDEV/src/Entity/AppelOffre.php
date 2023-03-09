<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * AppelOffre
 *
 * @ORM\Table(name="appel_offre", indexes={@ORM\Index(name="fk1", columns={"id_utilisateur"}), @ORM\Index(name="fk10", columns={"id_categorie"})})
 * @ORM\Entity
 */
class AppelOffre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("offres")
     */
    private $id;

    /**
     * 
     * @Assert\NotBlank(message=" nom  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Groups("offres")
     */
    private $nom;

    /**
     * @Assert\NotBlank(message=" quantite  est obligatoire")
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(1)
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     * @Groups("offres")
     */
    private $quantite;

    /**
     * @Assert\NotBlank(message=" budget  est obligatoire")
     * @Assert\Type(type="float")
     * @Assert\GreaterThan(1000)
     * @var float
     *
     * @ORM\Column(name="budget", type="float", precision=10, scale=0, nullable=false)
     * @Groups("offres")
     */
    private $budget;

    /**
  
     * @Assert\NotBlank(message=" description est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      minMessage=" Entrer un Description au mini de 8 caracteres"
     *
     *     )
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Groups("offres")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @Groups("offres")
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur_id", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie_id", referencedColumnName="id")
     * })
     */
    private $idCategorie;


  /**
     * @var int
     *
     * @Groups("offres")
     */
    private $idCa;
   
   
    /**
     * @var int
     *
     * @Groups("offres")
     */
    private $idU;
    public function getidCa(): ?int
    {
        return $this->idCategorie->getId();
    }
    public function getidU(): ?int
    {
        return $this->idUtilisateur->getId();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }
    public function id_utilisateur_id(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }
    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }
    public function id_categorie_id(): ?Categorie
    {
        return $this->idCategorie;
    }
    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function __toString()
    {
        return (String)$this->id;
    }

}
