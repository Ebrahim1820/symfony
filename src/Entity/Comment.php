<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;
    
      /**
     * @Gedmo\Slug(fields={"name"})
     
     */
    #[ORM\Column(length: 100, unique:true)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $commentedAt = null;

    #[ORM\Column(length: 50)]
    private ?string $author = null;

    #[ORM\Column]
    private ?int $heartCount = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFileName = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: Post::class, fetch:'EXTRA_LAZY')]
    #[ORM\OrderBy(['createdAt' =>'DESC'])]

    private Collection $posts;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'comments')]
    private Collection $tags;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCommentedAt(): ?\DateTime
    {
        return $this->commentedAt;
    }

    public function setCommentedAt(?\DateTime $commentedAt): static
    {
        $this->commentedAt = $commentedAt;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getHeartCount(): ?int
    {
        return $this->heartCount;
    }

    public function setHeartCount(int $heartCount): static
    {
        $this->heartCount = $heartCount;

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): static
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }


    public function getImagePath(){
        return 'images/'.$this->getImageFileName();
    }

    public function incrementHeartCount():self{
        $this->heartCount = $this->heartCount + 1;

        return $this;
    }


    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

      /**
     * @return Collection<int, Post>
     */
    public function getNonDeletedPosts(): Collection
    {
        // it's similar to query builder to loop over 
        // data and filter based on specific things
        // $criteria = Criteria::create()
        //     ->andWhere(Criteria::expr()->eq('isDeleted', false))
        //     ->orderBy([ 'createdAt' => 'DESC' ]);

        $criteria = CommentRepository::createNonDeletedCriteria();
        
        return $this->posts->matching($criteria);
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setComment($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getComment() === $this) {
                $post->setComment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }







}
