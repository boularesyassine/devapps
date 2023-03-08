<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Categorie;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fk5", columns={"id_categorie"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *@Groups({"groups", "Produit"})
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     
     * @Assert\NotBlank(message=" nom du produit obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Produit"})
     * @ORM\Column(name="nom_produit", type="string", length=255, nullable=false)
     */
    private $nomProduit;

    /**
     * @Assert\NotBlank(message=" description obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      minMessage=" Entrer une description au minimum de 8 caracteres"
     *
     *     ) 
     * @var string
     *@Groups({"groups", "Produit"})
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @Assert\NotBlank(message=" prix obligatoire")
     * @Assert\Type(type="float")
     * @var float
     *@Groups({"groups", "Produit"})
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     * @Assert\Positive(message=" le prix doit etre positive!")
     */

    private $prix;


    /**
     * @Assert\NotBlank(message=" quantite obligatoire")
     * @Assert\Type(type="integer")
     * @var int
     *@Groups({"groups", "Produit"})
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     * @Assert\Positive(message=" la quantité doit etre positive!")

     */
    private $quantite;

    /**
     * @Assert\NotBlank(message=" photo obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Produit"})
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var \DateTime
     *@Groups({"groups", "Produit"})
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     *
     *@Groups({"groups", "Produit"})
     * @ORM\ManyToOne(targetEntity=Categorie::class)
     * @ORM\JoinColumn(nullable=false)
     * })
     */

    private $idCategorie;


    private $id_Categorie_id;

  /**
     *
     * @var int
     *@Groups({"groups", "Produit"})
     */
    private $ide;

    public function id_produit(): ?int
    {
        return $this->idProduit;
    }
    public function getide(): ?int
    {
        return $this->idCategorie->getid();
    }

    public function getid(): ?int
    {
        return $this->idProduit;
    }

    public function getidProduit(): ?int
    {
        return $this->idProduit;
    }

    public function nom_produit(): ?string
    {
        return $this->nomProduit;
    }
    public function nomProduit(): ?string
    {
        return $this->nomProduit;
    }
    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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

    public function setId_Categorie_id(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function setIdCategories(?Categorie $idCategorie): self
    {
        $this->id_Categorie_id = $idCategorie;

        return $this;
    }
    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function __toString()
    {
        return (string)$this->id_produit();
    }
}
