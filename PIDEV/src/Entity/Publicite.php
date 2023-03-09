<?php

namespace App\Entity;
use Doctrine\DBAL\Types\type;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Sponsor;
use Symfony\Component\Validator\Constraints as Assert;
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
     *@Groups({"groups", "Publicite"})
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     
    * @Assert\NotBlank(message=" nomPub  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Publicite"})
     * @ORM\Column(name="nom_pub", type="string", length=255, nullable=false)
     */
    private $nomPub;

    /**
    * @Assert\NotBlank(message=" description est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      minMessage=" Entrer un Description au mini de 8 caracteres")
     *@Groups("Publicites")
     *     
     * @var string
     *@Groups({"groups", "Publicite"})
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @Assert\NotBlank(message=" image  est obligatoire")
     * @Assert\Type(type="string")
     * @var string
     *@Groups({"groups", "Publicite"})
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     * 
     */
    private $image;

    /**
     * @var \Sponsor
     *
     * @ORM\ManyToOne(targetEntity=Sponsor::class)
     * @ORM\JoinColumn(nullable=false)
     * })
     * 
     */

    private $idSponsor;


         /**
     * @var int
     *
     *@Groups({"groups", "Publicite"})
     */
    private $ide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIde(): ?int
    {
        return $this->idSponsor->getId();
    }


    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNomPub(): ?string
    {
        return $this->nomPub;
    }

    public function nom_pub(): ?string
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
