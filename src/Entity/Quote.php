<?php

namespace App\Entity;

use App\Repository\QuoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
#[ApiResource(operations:[        
        new Get(),        
        new GetCollection(),        
    ],
    normalizationContext:[
        'groups'=>['quote:read']
    ],
    paginationItemsPerPage:50)
]
#[ApiResource(    
    uriTemplate:'/author/{author_id}/quotes.{_format}',
    shortName:"Author",
    operations:[new GetCollection()],
    uriVariables:[
        'author_id'=>new Link(
            fromProperty: 'author',
            fromClass: Quote::class,
        )
    ],
    normalizationContext:[
        'groups'=>['quote:read']
    ],
        
)]
class Quote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quote:read'])]
    private ?int $id = null;

    
    /**
     * The Quote in itself
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups(['quote:read','author:read'])]
    private ?string $data = null;

    
    /**
     * Quote context and explanation
     *
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['quote:read'])]
    private ?string $explanation = null;

    /**
     * Quote Author
     *
     * @var string|null
     */
    #[ORM\ManyToOne(inversedBy: 'quotes')]
    #[Groups(['quote:read','user:read'])]
    private ?Author $author = null;

    #[ORM\ManyToOne(inversedBy: 'quotes')]
    private ?User $created_by = null;


    
    /**
     * Extra info about that quote
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['quote:read'])]
    private ?string $info = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt=new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(?string $explanation): static
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    #[Groups(['quote:read'])]
    public function getAuthorName(): ?string
    {
        return $this->author;
        //return "Author #33 lol";
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

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

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): static
    {
        $this->info = $info;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
