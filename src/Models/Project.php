<?php
// PROJECT MODEL

namespace App\Models;

use DateTime;

class Project
{
    public int $id_project;
    public string $title;
    public ?string $description;
    public string $date_start;
    public ?string $date_end;
    public ?string $link_web;
    public ?string $link_github;
    public ?string $image;
    public bool $active;
    public array $skills;

    public function getImage(): string
    {
        return $this->image ?? 'no-image.png';
    }

    public function getDateStart(): string
    {
        $datetime = DateTime::createFromFormat("Y-m-d", $this->date_start);
        return $datetime->format("d-m-Y");
    }

    public function getDateEnd(): ?string
    {
        if ($this->date_end) {
            $datetime = DateTime::createFromFormat("Y-m-d", $this->date_end);
            return $datetime->format("d-m-Y");
        }
        return null;
    }

    public function getStatut(): string
    {
        return $this->active ? 'Activé' : 'Désactivé';
    }
}
