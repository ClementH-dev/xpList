<?php

namespace App\Entity;

use App\Repository\ProjectChecklistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectChecklistRepository::class)]
class ProjectChecklist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $client = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, ChecklistTemplate>
     */
    #[ORM\ManyToMany(targetEntity: ChecklistTemplate::class, inversedBy: 'projectChecklists')]
    private Collection $template;

    /**
     * @var Collection<int, ProjectChecklistItem>
     */
    #[ORM\OneToMany(targetEntity: ProjectChecklistItem::class, mappedBy: 'project', orphanRemoval: true)]
    private Collection $projectChecklistItems;

    public function __construct()
    {
        $this->template = new ArrayCollection();
        $this->projectChecklistItems = new ArrayCollection();
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

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): static
    {
        $this->client = $client;

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

    /**
     * @return Collection<int, ChecklistTemplate>
     */
    public function getTemplate(): Collection
    {
        return $this->template;
    }

    public function addTemplate(ChecklistTemplate $template): static
    {
        if (!$this->template->contains($template)) {
            $this->template->add($template);
        }

        return $this;
    }

    public function removeTemplate(ChecklistTemplate $template): static
    {
        $this->template->removeElement($template);

        return $this;
    }

    /**
     * @return Collection<int, ProjectChecklistItem>
     */
    public function getProjectChecklistItems(): Collection
    {
        return $this->projectChecklistItems;
    }

    public function addProjectChecklistItem(ProjectChecklistItem $projectChecklistItem): static
    {
        if (!$this->projectChecklistItems->contains($projectChecklistItem)) {
            $this->projectChecklistItems->add($projectChecklistItem);
            $projectChecklistItem->setProject($this);
        }

        return $this;
    }

    public function removeProjectChecklistItem(ProjectChecklistItem $projectChecklistItem): static
    {
        if ($this->projectChecklistItems->removeElement($projectChecklistItem)) {
            // set the owning side to null (unless already changed)
            if ($projectChecklistItem->getProject() === $this) {
                $projectChecklistItem->setProject(null);
            }
        }

        return $this;
    }
}
