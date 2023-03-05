<?php
// ACCOUNT MODEL

namespace App\Models;

class Account
{
    public int $id_account;
    public string $email;
    public string $password;
    public string $hidden_password;
    public string $updated_at;

    public function getDate(): string
    {
        $date = implode('/', array_reverse(explode('-', explode(' ', $this->updated_at)[0])));
        return $date;
    }

    public function getTime(): string
    {
        $time = substr(explode(' ', $this->updated_at)[1], 0, 5);
        return $time;
    }
}
