<?php

declare(strict_types=1);

namespace App\Models\Interfaces;

use PDOException;

interface I_Model
{
    /**
     * Find a record by ID.
     *
     * @param  int $id The ID of the record to find.
     *
     * @return array<mixed> Returns an associative array representing the found record, or an empty array if not found.
     *
     * @throws PDOException If there is an error executing the database query.
     */
    public static function find(int $id): array;

    /**
     * Get all records from the table.
     *
     * @return array<mixed> Returns an array containing all records from the table.
     *
     * @throws PDOException If there is an error executing the database query.
     */
    public static function all(): array;

    /**
     * Create a new record in the table.
     *
     * @param array<mixed> $data An associative array containing the data for the new record.
     *
     * @throws PDOException If there is an error executing the database query.
     */
    public static function create(array $data): void;

    /**
     * Search for records in the database based on a column and a search query.
     *
     * @param  string $column The column in the database table to search.
     * @param  string $query  The search query to be used for the search.
     *
     * @return array<mixed> An array of associative arrays representing the matching records.
     * An empty array if no records are found or an error occurs.
     */
    public static function search(string $column, string $query): array;
}
