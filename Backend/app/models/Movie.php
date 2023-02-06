<?php
class Movie
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function getAll()
  {
    $this->db->query('SELECT movies.* , halls.name AS "hall_name" FROM movies INNER JOIN halls ON movies.hall_id = halls.id');
    return $this->db->resultSet();
  }

  public function getSingle($movie_id)
  {
    $this->db->query('SELECT movies.* , halls.name AS "hall_name" FROM movies INNER JOIN halls ON movies.hall_id = halls.id AND movies.id = :movie_id');
    $this->db->bind(':movie_id', $movie_id);
    return $this->db->single();
  }
}
