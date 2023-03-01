<?php
// MESSAGE MODEL
namespace App\Models;

class Message
{
    public int $id_message;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $content;
    public ?string $company;
    public ?string $phone;
    public string $created_at;
    public const PROFILE_COLOR = ['#379', '#397', '#739', '#793', '#937', '#973', '#888'];

    public function getContent(): string
    {
        return nl2br($this->content);
    }

    public function getDate(): string
    {
        $date = implode('/', array_reverse(explode('-', explode(' ', $this->created_at)[0])));
        return $date;
    }

    public function getTime(): string
    {
        $time = substr(explode(' ', $this->created_at)[1], 0, 5);
        return $time;
    }

    public function getRandomColor(): string
    {
        return $this::PROFILE_COLOR[mt_rand(0, count($this::PROFILE_COLOR) - 1)];
    }
}
