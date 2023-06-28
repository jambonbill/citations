<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

use Cocur\Slugify\Slugify;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ApiResource(operations:[
        //new Post(),
        new Get(),
        //new Put(),
        new GetCollection(),
        //new Post(),        
    ],
    normalizationContext:[
        'groups'=>['author:read']
    ],
    denormalizationContext:[
        'groups'=>['author:write']
    ],
    paginationItemsPerPage:50)
]
class Author
{
    /**
     * Author unique ID
     *
     * @var string|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['author:read'])]
    private ?int $id = null;

    /**
     * Author name
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups(['author:read'])]
    private ?string $name = null;

    
    /**
     * Author permalink/slug
     *
     * @var string|null
     */
    #[ORM\Column(length: 31, nullable: false)]
    #[Groups(['author:read'])]
    private ?string $slug = null;

    
    /**
     * Author biography
     *
     * @var string|null
     */
    #[ORM\Column(length: 1023, nullable: true)]
    #[Groups(['author:read'])]
    private ?string $bio = null;

    
    /**
     * Author record creation time
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    
    #[ORM\ManyToOne(inversedBy: 'authors')]
    private ?User $created_by = null;

    
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Quote::class)]
    #[Groups(['author:read'])]
    private Collection $quotes;

    
    
    private $slugify = null;//slugify service

    public function __construct()
    {
        $this->quotes = new ArrayCollection();
        $this->created_at=new \DateTimeImmutable();
        $this->slugify = new Slugify();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        //$slugify = new Slugify();
        $this->setSlug($name);

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return Collection<int, Quote>
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): static
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes->add($quote);
            $quote->setAuthor($this);
        }

        return $this;
    }

    public function removeQuote(Quote $quote): static
    {
        if ($this->quotes->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getAuthor() === $this) {
                $quote->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        //$slug=strtolower($slug);
        $slug=$this->slugify->slugify($slug);
        $this->slug = $slug;

        return $this;
    }
}
