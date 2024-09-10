<?php

    namespace App\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity]
    #[ORM\Table(name: 'editor')]
    class Editor
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[Assert\NotBlank]
        #[ORM\Column(type: 'string', length: 128)]
        private ?string $name = null;

        /**
         * @var Collection<int, Book>
         */
        #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'editor', orphanRemoval: true)]
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
                $book->setEditor($this);
            }

            return $this;
        }

        public function removeBook(Book $book): static
        {
            if ($this->books->removeElement($book)) {
                // set the owning side to null (unless already changed)
                if ($book->getEditor() === $this) {
                    $book->setEditor(null);
                }
            }

            return $this;
        }
    }