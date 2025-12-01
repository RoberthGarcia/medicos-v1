<?php

namespace App\Core;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Find all records
    public function all()
    {
        $this->db->query("SELECT * FROM {$this->table}");
        return $this->db->resultSet();
    }

    // Find record by ID
    public function find($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Find records by condition
    public function where($column, $value)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $this->db->bind(':value', $value);
        return $this->db->resultSet();
    }

    // Find single record by condition
    public function findBy($column, $value)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $this->db->bind(':value', $value);
        return $this->db->single();
    }

    // Delete record
    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
