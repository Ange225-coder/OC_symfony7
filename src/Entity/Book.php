<?php

    namespace App\Entity;

    use App\Enum\BookStatus;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity]
    #[ORM\Table(name: 'book')]
    class Book
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[Assert\NotBlank]
        #[Assert\Length(min: 4, max: 20)]
        #[ORM\Column(type: 'string', length: 128)]
        private ?string $title = null;

        #[Assert\NotBlank]
        #[Assert\Isbn(type: 'isbn13')]
        #[ORM\Column(type: 'string')]
        private ?string $isbn = null;

        #[Assert\NotBlank]
        #[Assert\Url]
        #[ORM\Column(type: 'string')]
        private ?string $cover = null;

        #[Assert\NotBlank]
        #[ORM\Column]
        private ?\DateTimeImmutable $editedAt = null;

        #[Assert\NotBlank]
        #[ORM\Column(type: 'text')]
        private ?string $plot = null;

        #[Assert\Positive]
        #[ORM\Column(type: 'integer')]
        private ?int $pageNumber = null;


        #[ORM\Column(type: 'string', enumType: BookStatus::class)]
        private ?BookStatus $status = null;

        #[ORM\ManyToOne(inversedBy: 'books')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Editor $editor = null;

    
        #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'book')]
        private Collection $comments;
        
        #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
        private Collection $author;

        public function __construct()
        {
            $this->comments = new ArrayCollection();
            $this->author = new ArrayCollection();
        }


        /**
         * @param BookStatus|null $status
         */
        public function setStatus(?BookStatus $status): void
        {
            $this->status = $status;
        }

        /**
         * @param string|null $cover
         */
        public function setCover(?string $cover): void
        {
            $this->cover = $cover;
        }

        /**
         * @param \DateTimeImmutable|null $editedAt
         */
        public function setEditedAt(?\DateTimeImmutable $editedAt): void
        {
            $this->editedAt = $editedAt;
        }

        /**
         * @param string|null $isbn
         */
        public function setIsbn(?string $isbn): void
        {
            $this->isbn = $isbn;
        }

        /**
         * @param int|null $pageNumber
         */
        public function setPageNumber(?int $pageNumber): void
        {
            $this->pageNumber = $pageNumber;
        }

        /**
         * @param string|null $plot
         */
        public function setPlot(?string $plot): void
        {
            $this->plot = $plot;
        }

        /**
         * @param string|null $title
         */
        public function setTitle(?string $title): void
        {
            $this->title = $title;
        }



        public function getId(): int
        {
            return $this->id;
        }

        /**
         * @return BookStatus|null
         */
        public function getStatus(): ?BookStatus
        {
            return $this->status;
        }

        /**
         * @return string|null
         */
        public function getCover(): ?string
        {
            return $this->cover;
        }

        /**
         * @return \DateTimeImmutable|null
         */
        public function getEditedAt(): ?\DateTimeImmutable
        {
            return $this->editedAt;
        }

        /**
         * @return string|null
         */
        public function getIsbn(): ?string
        {
            return $this->isbn;
        }

        /**
         * @return int|null
         */
        public function getPageNumber(): ?int
        {
            return $this->pageNumber;
        }

        /**
         * @return string|null
         */
        public function getPlot(): ?string
        {
            return $this->plot;
        }

        /**
         * @return string|null
         */
        public function getTitle(): ?string
        {
            return $this->title;
        }

        public function getEditor(): ?Editor
        {
            return $this->editor;
        }

        public function setEditor(?Editor $editor): static
        {
            $this->editor = $editor;

            return $this;
        }

        /**
         * @return Collection<int, Comment>
         */
        public function getComments(): Collection
        {
            return $this->comments;
        }

        public function addComment(Comment $comment): static
        {
            if (!$this->comments->contains($comment)) {
                $this->comments->add($comment);
                $comment->setBook($this);
            }

            return $this;
        }

        public function removeComment(Comment $comment): static
        {
            if ($this->comments->removeElement($comment)) {
                // set the owning side to null (unless already changed)
                if ($comment->getBook() === $this) {
                    $comment->setBook(null);
                }
            }

            return $this;
        }

        /**
         * @return Collection<int, Author>
         */
        public function getAuthor(): Collection
        {
            return $this->author;
        }

        public function addAuthor(Author $author): static
        {
            if (!$this->author->contains($author)) {
                $this->author->add($author);
            }

            return $this;
        }

        public function removeAuthor(Author $author): static
        {
            $this->author->removeElement($author);

            return $this;
        }
    }