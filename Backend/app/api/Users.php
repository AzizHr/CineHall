<?php
class Users extends Controller
{

  private $userModel;
  private $reservationModel;

  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->reservationModel = $this->model('Reservation');
  }


  public function reserve()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, 513);

      $data = [
        'hall_id' => $_POST['hall_id'],
        'user_id' => $_POST['user_id'],
        'seat_number' => $_POST['seat_number']
      ];

      if (!$this->reservationModel->getReservation(intval($data['seat_number']), intval($data['hall_id']))) {
        if ($this->reservationModel->getCapacity(intval($data['hall_id']))) {
          if ($this->reservationModel->add($data)) {
            if ($this->reservationModel->increaseCapacity($data['hall_id'])) {
              echo json_encode(['Success' => "Reserved With Success"]);
            } else {
              echo json_encode(['error' => "Error reserving"]);
            }
          } else {
            echo json_encode(['error' => "Error reserving"]);
          }
        } else {
          echo json_encode(['error' => "This hall is full"]);
        }
      } else {
        echo json_encode(['error' => "This seat is already taken"]);
      }
    }
  }


  public function register()
  {
    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $bytes = random_bytes(4);

      $_POST = filter_input_array(INPUT_POST, 513);

      $data = [
        'unique_key' => bin2hex($bytes),
        'first_name' => $_POST['fname'],
        'last_name' => $_POST['lname']
      ];


      if ($this->userModel->register($data)) {
        if ($this->userModel->login($data['unique_key'])) {
          echo json_encode([
            'Success' => "Registered With Success",
            'Ref' => 'Here is your ref to login with : `' . $this->userModel->login($data['unique_key'])['unique_key'] . '`'
          ]);
        }
      } else {
        echo json_encode(['error' => "Registered Failled"]);
      }
    }
  }

  public function login()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, 513);

      $unique_key = $_POST['unique_key'];

      if (empty($unique_key)) {
        echo json_encode(["error" => "please enter your unique key"]);
      } else {
        $loggedInUser = $this->userModel->login($unique_key);

        if ($loggedInUser) {
          echo json_encode($loggedInUser);
        } else {
          echo json_encode(["invalid" => "your unique key is invalid"]);
        }
      }
    }
  }

  public function delete($res_id)
  {
    if ($this->reservationModel->getHallId($res_id)) {
      $hall_id = $this->reservationModel->getHallId($res_id);
      if ($this->reservationModel->delete($res_id)) {
        if ($this->reservationModel->decreaseCapacity($hall_id)) {
          echo json_encode(["Success" => "Deleted With Success"]);
        }
      } else {
        echo json_encode(["Error" => "You can only cancel the reservations that are at least one day before the show date"]);
      }
    }
  }

  public function my_reservations()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, 513);
      $user_id = $_POST['user_id'];

      if ($this->reservationModel->getAll($user_id)) {
        echo json_encode($this->reservationModel->getAll($user_id));
      } else {
        echo json_encode(["None" => "You have no reservations yet"]);
      }
    } else {
      echo json_encode(["Error" => "404 ERROR"]);
    }
  }
}
