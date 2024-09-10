<?php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
    use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity]
    #[UniqueEntity(fields: ['email'], message: 'Um compte est déjà associé à cet email')]
    class User implements UserInterface, PasswordAuthenticatedUserInterface
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[Assert\NotBlank]
        #[Assert\Email]
        #[ORM\Column(type: 'string', length: 128, unique: true)]
        private ?string $email = null;

        #[Assert\NotBlank]
        #[ORM\Column(length: 20)]
        private ?string $firstName = null;

        #[Assert\NotBlank]
        #[ORM\Column(length: 45)]
        private ?string $lastName = null;

        #[ORM\Column(length: 25, nullable: true)]
        private ?string $username = null;

        #[ORM\Column]
        private array $roles = [];

        /**
         * La contrainte Regex valide que le mot de passe :
         * contient au moins un chiffre
         * contient au moins une lettre en minuscule
         * contient au moins une lettre en majuscule
         * contient au moins un caractère spécial qui n'est pas un espace
         * fait entre 8 et 32 caractères de long
         *
         */
        #[Assert\NotCompromisedPassword]
        #[Assert\PasswordStrength(minScore: Assert\PasswordStrength::STRENGTH_STRONG)]
        #[Assert\Regex('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).{8,32}$/')]
        #[ORM\Column]
        private ?string $password = null;


        //setters
        public function setUsername(?string $username): void
        {
            $this->username = $username;
        }

        public function setEmail(string $email): static
        {
            $this->email = $email;

            return $this;
        }

        public function setRoles(array $roles): static
        {
            $this->roles = $roles;

            return $this;
        }

        public function setPassword(string $password): static
        {
            $this->password = $password;

            return $this;
        }

        public function setLastName(?string $lastName): void
        {
            $this->lastName = $lastName;
        }

        public function setFirstName(?string $firstName): void
        {
            $this->firstName = $firstName;
        }




        //getters
        public function getId(): ?int
        {
            return $this->id;
        }

        public function getEmail(): ?string
        {
            return $this->email;
        }

        public function getUserIdentifier(): string
        {
            return (string) $this->email;
        }

        public function getRoles(): array
        {
            $roles = $this->roles;
            // guarantee every user at least has ROLE_USER
            $roles[] = 'ROLE_USER';

            return array_unique($roles);
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function getUsername(): ?string
        {
            return $this->username;
        }

        public function getLastName(): ?string
        {
            return $this->lastName;
        }

        public function getFirstName(): ?string
        {
            return $this->firstName;
        }

        public function eraseCredentials(): void
        {
            // If you store any temporary, sensitive data on the user, clear it here
            // $this->plainPassword = null;
        }
    }
