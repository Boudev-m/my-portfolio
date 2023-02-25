<?php
// PROJECT MODEL

class Project
{
    public int $id_project;
    public string $title;
    public ?string $text;
    public string $date_start;
    public ?string $date_end;
    public ?string $link;
    public ?string $image;
    public bool $active;

    public function getImage()
    {
        return $this->image ?? 'no-image.png';
    }

    public function getDateStart(): string
    {
        $datetime = DateTime::createFromFormat("Y-m-d", $this->date_start);
        return $datetime->format("d-m-Y");
    }

    public function getDateEnd(): string
    {
        $datetime = DateTime::createFromFormat("Y-m-d", $this->date_end);
        return $datetime->format("d-m-Y");
    }
}
