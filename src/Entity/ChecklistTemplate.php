<?php

namespace App\Entity;

use App\Repository\ChecklistTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChecklistTemplateRepository::class)]
class ChecklistTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, ChecklistItemTemplate>
     */
    #[ORM\OneToMany(targetEntity: ChecklistItemTemplate::class, mappedBy: 'checklistTemplate', orphanRemoval: true, cascade: ["persist", "remove"])]
    private Collection $items;

    /**
     * @var Collection<int, ProjectChecklist>
     */
    #[ORM\ManyToMany(targetEntity: ProjectChecklist::class, mappedBy: 'template')]
    private Collection $projectChecklists;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->projectChecklists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ChecklistItemTemplate>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ChecklistItemTemplate $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setChecklistTemplate($this);
        }

        return $this;
    }

    public function removeItem(ChecklistItemTemplate $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getChecklistTemplate() === $this) {
                $item->setChecklistTemplate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProjectChecklist>
     */
    public function getProjectChecklists(): Collection
    {
        return $this->projectChecklists;
    }

    public function addProjectChecklist(ProjectChecklist $projectChecklist): static
    {
        if (!$this->projectChecklists->contains($projectChecklist)) {
            $this->projectChecklists->add($projectChecklist);
            $projectChecklist->addTemplate($this);
        }

        return $this;
    }

    public function removeProjectChecklist(ProjectChecklist $projectChecklist): static
    {
        if ($this->projectChecklists->removeElement($projectChecklist)) {
            $projectChecklist->removeTemplate($this);
        }

        return $this;
    }
}
