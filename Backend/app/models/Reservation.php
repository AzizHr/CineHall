<?php
class Reservation
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll($user_id)
    {
        $this->db->query('SELECT * FROM reservations WHERE user_id = :user_id');
        $this->db->bind(":user_id", $user_id);
        $result = $this->db->resultSet();

        if ($this->db->rowCount() == 0) {
            false;
        } else {
            return $result;
        }
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO reservations (hall_id , user_id , seat_number) VALUES (:hall_id , :user_id , :seat_number)');
        $this->db->bind(":hall_id", $data['hall_id']);
        $this->db->bind(":user_id", $data['user_id']);
        $this->db->bind(":seat_number", $data['seat_number']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Increase Hall Capacity When New Reservation Added
    public function increaseCapacity($id)
    {
        $this->db->query('UPDATE halls SET seats = seats + 1 WHERE id = :id');
        $this->db->bind(":id", $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // Decrease Hall Capacity When New Reservation Deleted
    public function decreaseCapacity($id)
    {
        $this->db->query('UPDATE halls SET seats = seats - 1 WHERE id = :id');
        $this->db->bind(":id", $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getReservation($seat_number, $hall_id)
    {
        $this->db->query('SELECT * FROM reservations WHERE seat_number = :seat_number AND hall_id = :hall_id');
        $this->db->bind(":seat_number", $seat_number);
        $this->db->bind(":hall_id", $hall_id);

        $result = $this->db->single();

        if ($result == false) {
            return false;
        } else {
            if ($result['seat_number'] === $seat_number) {
                return true;
            }
        }
    }

    public function getCapacity($hall_id)
    {
        $this->db->query('SELECT seats AS "reserved" FROM halls WHERE id = :hall_id');
        $this->db->bind(":hall_id", $hall_id);

        $result = $this->db->single();

        if ($result == false) {
            return false;
        } else {
            if ($result['reserved'] === 30) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function delete($res_id)
    {
        $this->db->query('SELECT * FROM reservations WHERE hall_id IN (SELECT hall_id FROM films WHERE DATEDIFF(date , CURDATE()) > 1) AND id = :res_id');
        $this->db->bind(":res_id", $res_id);
        $this->db->execute();
        if ($this->db->rowCount() === 0) {
            return false;
        } else {
            $this->db->query('DELETE FROM reservations WHERE id = :res_id');
            $this->db->bind(":res_id", $res_id);
            $this->db->execute();
            return true;
        }
    }

    public function getHallId($res_id)
    {
        $this->db->query('SELECT hall_id FROM reservations WHERE id = :res_id');
        $this->db->bind(':res_id', $res_id);
        $row = $this->db->single();
        return $row['hall_id'];
    }
}
