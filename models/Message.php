<?php
// MESSAGE MODEL

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
}
