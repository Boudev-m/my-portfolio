<?php
// SKILL MODEL

class Skill
{
    public int $id_skill;
    public string $title;
    public int $type;
    public ?string $text;
    public ?string $image;
    public ?string $link;
    public bool $active;
}
