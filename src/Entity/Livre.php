<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Auteur::class, inversedBy="livres",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeEdition;

    /**
     * @ORM\OneToMany(targetEntity=EntreeLivre::class, mappedBy="livre")
     */
    private $entreeLivres;

    /**
     * @ORM\OneToMany(targetEntity=SortieLivre::class, mappedBy="livre")
     */
    private $sortieLivres;

    public function __construct()
    {
        $this->entreeLivres = new ArrayCollection();
        $this->sortieLivres = new ArrayCollection();
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

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAnneeEdition(): ?int
    {
        return $this->anneeEdition;
    }

    public function setAnneeEdition(int $anneeEdition): self
    {
        $this->anneeEdition = $anneeEdition;

        return $this;
    }

    /**
     * @return Collection<int, EntreeLivre>
     */
    public function getEntreeLivres(): Collection
    {
        return $this->entreeLivres;
    }

    public function addEntreeLivre(EntreeLivre $entreeLivre): self
    {
        if (!$this->entreeLivres->contains($entreeLivre)) {
            $this->entreeLivres[] = $entreeLivre;
            $entreeLivre->setLivre($this);
        }

        return $this;
    }

    public function removeEntreeLivre(EntreeLivre $entreeLivre): self
    {
        if ($this->entreeLivres->removeElement($entreeLivre)) {
            // set the owning side to null (unless already changed)
            if ($entreeLivre->getLivre() === $this) {
                $entreeLivre->setLivre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SortieLivre>
     */
    public function getSortieLivres(): Collection
    {
        return $this->sortieLivres;
    }

    public function addSortieLivre(SortieLivre $sortieLivre): self
    {
        if (!$this->sortieLivres->contains($sortieLivre)) {
            $this->sortieLivres[] = $sortieLivre;
            $sortieLivre->setLivre($this);
        }

        return $this;
    }

    public function removeSortieLivre(SortieLivre $sortieLivre): self
    {
        if ($this->sortieLivres->removeElement($sortieLivre)) {
            // set the owning side to null (unless already changed)
            if ($sortieLivre->getLivre() === $this) {
                $sortieLivre->setLivre(null);
            }
        }

        return $this;
    }
}
