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

    public function __construct()
    {
    }

    public function displayDateStart(): string
    {
        $datetime = DateTime::createFromFormat("Y-m-d", $this->date_start);
        return $datetime->format("d-m-Y");
    }

    public function displayDateEnd(): string
    {
        $datetime = DateTime::createFromFormat("Y-m-d", $this->date_end);
        return $datetime->format("d-m-Y");
    }
}
