<?php
class Reservation

{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function allClientReservations($client_id)
    {
        $this->db->query('SELECT * FROM reservations INNER JOIN halls ON reservations.hall_id_fk = halls.hall_id INNER JOIN movies ON reservations.movie_id_fk = movies.movie_id AND client_id_fk = :client_id');
        $this->db->bind(':client_id', $client_id);
        return $this->db->all();
    }

    public function checkIfExist($info)
    {
        $this->db->query('SELECT * FROM reservations WHERE hall_id_fk = :hall_id_fk AND movie_id_fk = :movie_id_fk AND client_id_fk = :client_id_fk AND seat_number = :seat_number');
        $this->db->bind(':hall_id_fk', $info['hall_id_fk']);
        $this->db->bind(':movie_id_fk', $info['movie_id_fk']);
        $this->db->bind(':client_id_fk', $info['client_id_fk']);
        $this->db->bind(':seat_number', $info['seat_number']);
        $this->db->execute();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function increaseReservedSeats($hall_id, $movie_id)
    {
        $this->db->query('UPDATE shown SET reserved_seats = reserved_seats + 1 WHERE hall_id_fk = :hall_id_fk AND movie_id_fk = :movie_id_fk');
        $this->db->bind(':hall_id_fk', $hall_id);
        $this->db->bind(':movie_id_fk', $movie_id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function decreaseReservedSeats($hall_id, $movie_id)
    {
        $this->db->query('UPDATE shown SET reserved_seats = reserved_seats - 1 WHERE hall_id_fk = :hall_id_fk AND movie_id_fk = :movie_id_fk');
        $this->db->bind(':hall_id_fk', $hall_id);
        $this->db->bind(':movie_id_fk', $movie_id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get($id)
    {
        $this->db->query('SELECT * FROM reservations INNER JOIN shown ON reservations.hall_id_fk = shown.hall_id_fk AND reservations.movie_id_fk = shown.movie_id_fk AND DATEDIFF(shown.shown_at , CURDATE()) > 1 AND reservations.id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        if ($this->db->rowCount() > 0) {
            return $this->db->single();
        } else {
            return false;
        }
    }

    public function drop($id)
    {
        // var_dump($this->get($id));
        // die;
        if ($this->get($id) !== false) {
            $hall_id = $this->get($id)->hall_id_fk;
            $movie_id = $this->get($id)->movie_id_fk;
            $this->db->query('DELETE FROM reservations WHERE id = :id');
            $this->db->bind(':id', $id);
            if ($this->db->execute()) {
                if ($this->decreaseReservedSeats($hall_id, $movie_id)) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public function store($info)
    {
        if (!$this->checkIfExist($info)) {
            $this->db->query('INSERT INTO reservations (hall_id_fk , movie_id_fk , client_id_fk , seat_number) VALUES (:hall_id_fk , :movie_id_fk , :client_id_fk , :seat_number)');
            $this->db->bind(':hall_id_fk', $info['hall_id_fk']);
            $this->db->bind(':movie_id_fk', $info['movie_id_fk']);
            $this->db->bind(':client_id_fk', $info['client_id_fk']);
            $this->db->bind(':seat_number', $info['seat_number']);
            if ($this->db->execute()) {
                if ($this->increaseReservedSeats($info['hall_id_fk'] , $info['movie_id_fk'])) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }
}
