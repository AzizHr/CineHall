<?php
class User
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function getAll()
  {
    $this->db->query('SELECT * FROM users');
    return $this->db->resultSet();
  }
  // Regsiter user
  public function register($data)
  {
    $this->db->query('INSERT INTO users (user_ref , first_name, last_name) VALUES(:user_ref , :first_name , :last_name)');
    // Bind values
    $this->db->bind(':user_ref', $data['user_ref']);
    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Login User
  public function login($user_ref)
  {
    $this->db->query('SELECT * FROM users WHERE user_ref = :user_ref');
    $this->db->bind(':user_ref', $user_ref);

    $row = $this->db->single();

    if ($row) {
      return $row;
    } else {
      return false;
    }
  }
}
