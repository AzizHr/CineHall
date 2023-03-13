<?php
class Movie
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function allMovies()
  {
    $this->db->query('SELECT * FROM movies INNER JOIN shown ON movies.movie_id = shown.movie_id_fk INNER JOIN halls ON shown.hall_id_fk = halls.hall_id');
    return $this->db->all();
  }

  public function singleMovie($shown_at)
  {
    $this->db->query('SELECT * FROM movies INNER JOIN shown ON movies.movie_id = shown.movie_id_fk INNER JOIN halls ON shown.hall_id_fk = halls.hall_id AND shown.shown_at = :shown_at');
    $this->db->bind(':shown_at', $shown_at);
    return $this->db->single();
  }

  public function filter($shown_at)
  {
    $this->db->query('SELECT * FROM movies INNER JOIN shown ON movies.movie_id = shown.movie_id_fk AND shown.shown_at = :shown_at');
    $this->db->bind(':shown_at', $shown_at);
    return $this->db->all();
  }

  public function reserved_seats($shown_at)
  {
    $this->db->query('SELECT seat_number FROM reservations INNER JOIN shown ON reservations.movie_id_fk = shown.movie_id_fk AND reservations.hall_id_fk = shown.hall_id_fk AND shown.shown_at = :shown_at');
    $this->db->bind(':shown_at' , $shown_at);
    $this->db->execute();
    return $this->db->colums();
  }

  // public function allShownAtDates($movie_id_fk)
  // {
  //   $this->db->query('SELECT * FROM shown WHERE movie_id_fk = :movie_id_fk');
  //   $this->db->bind(':movie_id_fk' , $movie_id_fk);
  //   return $this->db->all();
  // }

  // public function allHalls($movie_id_fk)
  // {
  //   $this->db->query('SELECT * FROM halls INNER JOIN shown ON halls.hall_id = shown.hall_id_fk AND movie_id_fk = :movie_id_fk');
  //   $this->db->bind(':movie_id_fk' , $movie_id_fk);
  //   return $this->db->all();
  // }

  // public function get_movie($info)
  // {
  //   $this->db->query('SELECT * FROM movies INNER JOIN shown ON movies.movie_id = shown.movie_id_fk INNER JOIN halls ON shown.hall_id_fk = halls.hall_id AND shown.movie_id_fk = :movie_id_fk AND shown.shown_at = :shown_at');
  //   $this->db->bind(':movie_id_fk' , $info['movie_id_fk']);
  //   // $this->db->bind(':hall_id_fk' , $info['hall_id_fk']);
  //   $this->db->bind(':shown_at' , $info['shown_at']);
    
  //   if($this->db->execute())
  //   {
  //     return $this->db->all();
  //   }
  // }
}
