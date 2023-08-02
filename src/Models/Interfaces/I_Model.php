<?php
namespace App\Models\Interfaces;

use PDOException;

interface I_Model {
        /**
     * Find a record by ID.
     *
     * @param int $id The ID of the record to find.
     * @return array Returns an associative array representing the found record, or an empty array if not found.
     * @throws PDOException If there is an error executing the database query.
     */
    public static function find(int $id): array;

    /**
     * Get all records from the table.
     *
     * @return array Returns an array containing all records from the table.
     * @throws PDOException If there is an error executing the database query.
     */
    public static function all(): array;

    /**
     * Create a new record in the table.
     *
     * @param array $data An associative array containing the data for the new record.
     * @throws PDOException If there is an error executing the database query.
     */
    public static function create(array $data): void;
}