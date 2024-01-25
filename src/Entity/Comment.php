<?php

namespace App\Entity;

use App\Repository\CommentRepository;
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

    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // /**
    //  * Summary of createdAt
    //  * @Gedmo\Timestampable(on="create")
    //  */
    // private ?\DateTime $createdAt = null;

    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // /**
    //  * Summary of updateAt
    //  * @Gedmo\Timestampable(on="update")
    //  */
    // private ?\DateTime $updatedAt = null;









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

    // public function getCreatedAt(): ?\DateTime
    // {
    //     return $this->createdAt;
    // }

    // public function setCreatedAt(\DateTime $createdAt): static
    // {
    //     $this->createdAt = $createdAt;

    //     return $this;
    // }

    // public function getUpdatedAt(): ?\DateTime
    // {
    //     return $this->updatedAt;
    // }

    // public function setUpdatedAt(\DateTime $updatedAt): static
    // {
    //     $this->updatedAt = $updatedAt;

    //     return $this;
    // }







}
