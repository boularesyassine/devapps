<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="fk7", columns={"id_utilisateur"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     * @ORM\Column(name="id_rec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRec;

    /**
     * @Assert\NotBlank(message=" sujet  est obligatoire")
     * @Assert\Type(type="string")
     * @Assert\Regex(
     *     pattern="/\b[A-Z0-9]+\b/",
     *     message="The value {{ value }} is not a valid uppercase text."
     * )
     * @var string
     *@Groups({"groups", "Reclamation"})
     * @ORM\Column(name="sujet", type="string", length=255, nullable=false)
     */
    private $sujet;

    /**
     * @Assert\NotBlank(message=" email  est obligatoire")
     * @Assert\Type(type="string") 
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     *     message="not_valid_email"
     * )
     * @var string
     *@Groups({"groups", "Reclamation"})
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     
     * @Assert\NotBlank(message=" description est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      minMessage=" Entrer un Description au mini de 8 caracteres"
     *
     *     ) 
     * @var string
     *@Groups({"groups", "Reclamation"})
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @Assert\NotBlank(message=" etat  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Reclamation"})
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \DateTime
     *@Groups({"groups", "Reclamation"})
     * @ORM\Column(name="date", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date ;

    /**
     * @var \Utilisateur
     *@Groups({"groups", "Reclamation"})
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     */


    private $idUtilisateur;

    public function id_rec(): ?int
    {
        return $this->idRec;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getIdUtilisateur(): ?Utilisateur
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
        return (String)$this->idRec;
    }

}
