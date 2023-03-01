<?php
// SKILL MODEL
namespace App\Models;

class Skill
{
    public int $id_skill;
    public string $title;
    public int $type;       // 1=front-end , 2=back-end
    public ?string $description;
    public ?string $image;
    public ?string $link;
    public bool $active;    // 1=active , 0=inactive

    public function getImage(): string
    {
        return $this->image ?? 'no-image.png';
    }

    public function getType(): array
    {
        if ($this->type === 1) {
            return [
                'color' => 'red',
                'type' => 'Front-end'
            ];
        } else {
            return [
                'color' => 'blue',
                'type' => 'Back-end'
            ];
        }
    }

    public function getStatut(): string
    {
        return $this->active ? 'Activé' : 'Désactivé';
    }
}
