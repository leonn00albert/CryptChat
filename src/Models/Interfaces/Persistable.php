<?php
namespace App\Models\Interfaces;

use PDOException;

interface Persistable
{
    /**
     * Save the user to the database.
     *
     * If the user does not have a keypair (publicKey and privateKey),
     * a new keypair will be generated and assigned before saving to the database.
     *
     * @return bool Returns true on successful save, or false if there was an error.
     * @throws PDOException If there is an error executing the database query.
     */
    public function save(): bool;
}
