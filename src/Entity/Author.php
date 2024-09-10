<?php

    namespace App\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity]
    class Author
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[Assert\Length(min: 10)]
        #[Assert\NotBlank(message: 'Entrez un nom')]
        #[ORM\Column(type: 'string', unique: true)]
        private ?string $name;

        #[Assert\NotBlank(message: 'Ajouter une date')]
        #[ORM\Column]
        private ?\DateTimeImmutable $dateOfBirth = null;

        #[Assert\GreaterThan(propertyPath: 'dateOfBirth')]
        #[ORM\Column(nullable: true)]
        private ?\DateTimeImmutable $dateOfDeath = null;

        #[ORM\Column(type: 'string', length: 55, nullable: true)]
        private ?string $nationality = null;
        
        #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'author')]
        private Collection $books;

        public function __construct()
        {
            $this->books = new ArrayCollection();
        }


        /**
         * @param string|null $name
         */
        public function setName(?string $name): void
        {
            $this->name = $name;
        }

        /**
         * @param \DateTimeImmutable|null $dateOfBirth
         */
        public function setDateOfBirth(?\DateTimeImmutable $dateOfBirth): void
        {
            $this->dateOfBirth = $dateOfBirth;
        }

        /**
         * @param \DateTimeImmutable|null $dateOfDeath
         */
        public function setDateOfDeath(?\DateTimeImmutable $dateOfDeath): void
        {
            $this->dateOfDeath = $dateOfDeath;
        }

        /**
         * @param string|null $nationality
         */
        public function setNationality(?string $nationality): void
        {
            $this->nationality = $nationality;
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
         * @return \DateTimeImmutable|null
         */
        public function getDateOfBirth(): ?\DateTimeImmutable
        {
            return $this->dateOfBirth;
        }

        /**
         * @return \DateTimeImmutable|null
         */
        public function getDateOfDeath(): ?\DateTimeImmutable
        {
            return $this->dateOfDeath;
        }

        /**
         * @return string|null
         */
        public function getNationality(): ?string
        {
            return $this->nationality;
        }

        /**
         * @return Collection<int, Book>
         */
        public function getBooks(): Collection
        {
            return $this->books;
        }

        public function addBook(Book $book): static
        {
            if (!$this->books->contains($book)) {
                $this->books->add($book);
                $book->addAuthor($this);
            }

            return $this;
        }

        public function removeBook(Book $book): static
        {
            if ($this->books->removeElement($book)) {
                $book->removeAuthor($this);
            }

            return $this;
        }
    }
