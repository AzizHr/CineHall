<?php
class Client
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  // Client Registration
  public function register($client_info)
  {
    $this->db->query('INSERT INTO clients (ref , first_name, last_name) VALUES(:ref , :first_name , :last_name)');
    // Bind values
    $this->db->bind(':ref', $client_info['ref']);
    $this->db->bind(':first_name', $client_info['first_name']);
    $this->db->bind(':last_name', $client_info['last_name']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Client Authentication
  public function login($ref)
  {
    $this->db->query('SELECT * FROM clients WHERE ref = :ref');
    $this->db->bind(':ref', $ref);

    if ($this->db->single()) {
      return $this->db->single();
    } else {
      return false;
    }
  }
}
