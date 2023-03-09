<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ReponseReclamation
 *
 * @ORM\Table(name="reponse_reclamation", indexes={@ORM\Index(name="fk9", columns={"id_reclamation"})})
 * @ORM\Entity
 */
class ReponseReclamation
{
    /**
     * @var int
     *@Groups({"groups", "ReponseReclamation"})
     * @ORM\Column(name="id_reponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReponse;

    /**
     * @Assert\NotBlank(message=" sujet  est obligatoire")
     * @Assert\Type(type="string") 
     * @var string
     *@Groups({"groups", "ReponseReclamation"})
     * @ORM\Column(name="sujet", type="string", length=255, nullable=false)
     */
    private $sujet;

    /**
     * @Assert\NotBlank(message=" etat  est obligatoire")
     * @Assert\Type(type="string") 
     * @var string
     *@Groups({"groups", "ReponseReclamation"})
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \DateTime
     *@Groups({"groups", "ReponseReclamation"})
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \Reclamation
     *@Groups({"groups", "ReponseReclamation"})
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reclamation", referencedColumnName="id_rec")
     * })
     */
    private $idReclamation;



    /**
     * @var int
     *@Groups({"groups", "ReponseReclamation"})
     */
    private $idRe;
    public function getIdReponse(): ?int
    {
        return $this->idReponse;
    }


    public function id_reponse(): ?int
    {
        return $this->idReponse;
    }

    public function getidRe(): ?int
    {
        return $this->idReclamation->getidRec();
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

    public function getIdReclamation(): ?Reclamation
    {
        return $this->idReclamation;
    }
    public function id_reclamation(): ?Reclamation
    {
        return $this->idReclamation;
    }
    public function setIdReclamation(?Reclamation $idReclamation): self
    {
        $this->idReclamation = $idReclamation;

        return $this;
    }


}
