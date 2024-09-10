<?php

    namespace App\Entity;

    use App\Enum\CommentStatus;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity]
    class Comment
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[Assert\NotBlank]
        #[Assert\Length(min: 3)]
        #[ORM\Column(type: 'string')]
        private ?string $name = null;

        #[Assert\NotBlank]
        #[Assert\Email]
        #[ORM\Column(type: 'string')]
        private ?string $email = null;

        #[ORM\Column]
        private ?\DateTimeImmutable $createdAt = null;

        #[Assert\NotBlank]
        #[ORM\Column]
        private ?\DateTimeImmutable $publishedAt = null;

        #[ORM\Column(type: 'string')]
        private ?CommentStatus $commentStatus = null;

        #[Assert\NotBlank]
        #[ORM\Column(type: 'text')]
        private ?string $context = null;

        #[Assert\NotBlank]
        #[ORM\ManyToOne(inversedBy: 'comments')]
        private ?Book $book = null;

        /**
         * @param string|null $name
         */
        public function setName(?string $name): void
        {
            $this->name = $name;
        }

        /**
         * @param string|null $email
         */
        public function setEmail(?string $email): void
        {
            $this->email = $email;
        }

        /**
         * @param \DateTimeImmutable|null $createdAt
         */
        public function setCreatedAt(?\DateTimeImmutable $createdAt): void
        {
            $this->createdAt = $createdAt;
        }

        /**
         * @param \DateTimeImmutable|null $publishedAt
         */
        public function setPublishedAt(?\DateTimeImmutable $publishedAt): void
        {
            $this->publishedAt = $publishedAt;
        }

        /**
         * @param CommentStatus|null $commentStatus
         */
        public function setCommentStatus(?CommentStatus $commentStatus): void
        {
            $this->commentStatus = $commentStatus;
        }

        /**
         * @param string|null $context
         */
        public function setContext(?string $context): void
        {
            $this->context = $context;
        }


        //getters

        /**
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * @return string|null
         */
        public function getName(): ?string
        {
            return $this->name;
        }

        /**
         * @return string|null
         */
        public function getEmail(): ?string
        {
            return $this->email;
        }

        /**
         * @return \DateTimeImmutable|null
         */
        public function getCreatedAt(): ?\DateTimeImmutable
        {
            return $this->createdAt;
        }

        /**
         * @return \DateTimeImmutable|null
         */
        public function getPublishedAt(): ?\DateTimeImmutable
        {
            return $this->publishedAt;
        }

        /**
         * @return CommentStatus|null
         */
        public function getCommentStatus(): ?CommentStatus
        {
            return $this->commentStatus;
        }

        /**
         * @return string|null
         */
        public function getContext(): ?string
        {
            return $this->context;
        }

        public function getBook(): ?Book
        {
            return $this->book;
        }

        public function setBook(?Book $book): static
        {
            $this->book = $book;

            return $this;
        }
    }