<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="fk4", columns={"id_utilisateur"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     * @Groups("facture")
     * @ORM\Column(name="id_facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFacture;

    /**
     *  @Assert\NotBlank(message=" numero  est obligatoire")
     * @Assert\Type(type="integer")
     * @var int
   * @Groups("facture")
     * @ORM\Column(name="numero", type="integer", nullable=false)
     */
    private $numero;

    /**
     *  @Assert\NotBlank(message=" nom  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     * @Groups("facture")
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     *@Assert\NotBlank(message=" prix  est obligatoire")
     * @Assert\Type(type="float")
     * @var float
     * @Groups("facture")
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var \DateTime
     * @Groups("facture")
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @Assert\NotBlank(message=" etat  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     * @Groups("facture")
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @Assert\NotBlank(message=" description est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      minMessage=" Entrer un Description au mini de 8 caracteres"
     *
     *     )
     * @var string
     * @Groups("facture")
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @Assert\NotBlank(message=" image  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     * @Groups("facture")
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    public function getIdFacture(): ?int
    {
        return $this->idFacture;
    }

    public function setIdFacture(int $idFacture): self
    {
        $this->idFacture = $idFacture;

        return $this;
    }
    public function getid(): ?int
    {
        return $this->idFacture;
    }
    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }
    public function id_utilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }
    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }
    public function __toString()
        {
            return (String)$this->id;
        }
    

}
