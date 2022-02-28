<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: PostRepository::class)]

#[ApiResource(
 paginationItemsPerPage:2,
 paginationClientItemsPerPage:true,
 normalizationContext:['groups'=>['read:collection']],
 denormalizationContext: ['groups'=>['write:Post']],

 collectionOperations:[
    'get',
    'post'=>[
        'validation_groups'=>['create:Post']
    ]
]
,
itemOperations: [ 
    'put'
    // =>[
    //     'denormalization_context' => ['groups'=>['put:Post']]
    // ]
    ,
    'delete',
    'get'=>[
    'normalization_context' => ['groups'=>['read:collection','read:item','read:Post']]
]
]
),
ApiFilter(SearchFilter::class, properties:["id"=>"exact","titel"=>"partial"])] 
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:collection'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collection','write:Post']),
    Length(min:5,groups:['create:Post'])]
    private $titel;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collection','write:Post'])]
    private $slug;

    // #[ORM\Column(type: 'text')]
    #[Groups(['read:collection'])]
    private $content;

    #[Groups(['read:item'])]
    #[ORM\Column(type: 'datetime')]
    private $createdat;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['read:item'])]
    private $updatetime;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts',cascade:["persist"])]
    #[Groups(['read:item','write:post'])]
    private $category;

    
public function __construct()
{
$this->createdat= new \DateTime()  ;
$this->updatetime= new \DateTime()  ;

}


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): self
    {
        $this->titel = $titel;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatetime(): ?\DateTimeInterface
    {
        return $this->updatetime;
    }

    public function setUpdatetime(\DateTimeInterface $updatetime): self
    {
        $this->updatetime = $updatetime;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

  
}
