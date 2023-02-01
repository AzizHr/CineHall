<?php
class User
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  // Regsiter user
  public function register($data)
  {
    $this->db->query('INSERT INTO users (unique_key , first_name, last_name) VALUES(:unique_key , :first_name , :last_name)');
    // Bind values
    $this->db->bind(':unique_key', $data['unique_key']);
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
  public function login($unique_key)
  {
    $this->db->query('SELECT * FROM users WHERE unique_key = :unique_key');
    $this->db->bind(':unique_key', $unique_key);

    $row = $this->db->single();

    if ($row) {
      return $row;
    } else {
      return false;
    }
  }
}
