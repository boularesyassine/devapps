<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor")
 * @ORM\Entity
 */
class Sponsor
{
    /**
     * @var int
     *@Groups({"groups", "Sponsor"})
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
    * @Assert\NotBlank(message=" nom  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Sponsor"})
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
    * @Assert\NotBlank(message=" adresse  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Sponsor"})
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @Assert\NotBlank(message=" email  est obligatoire")
     * @Assert\Type(type="string") 
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     *     message="not_valid_email"
     * )
     * @var string
     *@Groups({"groups", "Sponsor"})
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
    * @Assert\NotBlank(message=" num_tel  est obligatoire")
     * @Assert\Type(type="integer") 
     * @var int
     *@Groups({"groups", "Sponsor"})
     * @ORM\Column(name="num_tel", type="integer", nullable=false)
     */
    private $numTel;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getNumTel(): ?int
    {
        return $this->numTel;
    }
    public function getnum_tel(): ?int
    {
        return $this->numTel;
    }
    public function setNumTel(int $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }


}
