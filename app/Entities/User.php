<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    // Specify the fields available in this entity
    protected $attributes = [
        'id_user'       => null,
        'nama_lengkap'  => null,
        'username'      => null,
        'password'      => null,
        'role'          => null,
    ];

    // Fields that should be automatically mutated to/from
    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    /**
     * Hash the password before saving
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the password
     *
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes['password']);
    }
}
