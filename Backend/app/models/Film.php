<?php
class Film
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function getAll()
  {
    $this->db->query('SELECT films.* , halls.name AS "hall_name" FROM films INNER JOIN halls ON films.hall_id = halls.id');
    return $this->db->resultSet();
  }

  public function getSingle($film_id)
  {
    $this->db->query('SELECT films.* , halls.name AS "hall_name" FROM films INNER JOIN halls ON films.hall_id = halls.id AND films.id = :film_id');
    $this->db->bind(':film_id', $film_id);
    return $this->db->single();
  }
}
