<?php
namespace Application\Action;

class FetchNotes
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchAll()
    {
        
        // $statement = $this->db->query('SELECT * FROM notes;');

    }
}