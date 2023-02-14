<?php

class Users extends Controller
{
  private $userModel;
  private $reservationModel;

  public function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $this->userModel = $this->model('User');
    $this->reservationModel = $this->model('Reservation');
  }

  public function all()
  {
    echo json_encode($this->userModel->getAll());
  }
  public function reserve()
  {

    header("Access-Control-Allow-Methods: POST");

    $data = [
      'hall_id' => $_POST['hall_id'],
      'user_ref' => $_POST['user_ref'],
      'seat_number' => $_POST['seat_number'],
      'showed_at' => $_POST['showed_at']
    ];

    if (!$this->reservationModel->getReservation(intval($data['seat_number']), intval($data['hall_id']))) {
      if ($this->reservationModel->getCapacity(intval($data['hall_id']))) {
        if ($this->reservationModel->add($data)) {
          if ($this->reservationModel->increaseCapacity($data['hall_id'])) {
            echo json_encode(['Success' => "Reserved With Success"]);
          } else {
            echo json_encode(['Error' => "Error reserving"]);
          }
        } else {
          echo json_encode(['Error' => "Error reserving"]);
        }
      } else {
        echo json_encode(['Error' => "This hall is full"]);
      }
    } else {
      echo json_encode(['Error' => "This seat is already taken"]);
    }
  }


  public function register()
  {
    header("Access-Control-Allow-Methods: POST");
    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $bytes = random_bytes(4);

      $_POST = filter_input_array(INPUT_POST, 513);

      $data = [
        'user_ref' => bin2hex($bytes),
        'first_name' => $_POST['fname'],
        'last_name' => $_POST['lname']
      ];


      if ($this->userModel->register($data)) {
        if ($this->userModel->login($data['user_ref'])) {
          echo json_encode([
            'Success' => "Registered With Success",
            'Ref' => 'Here is your ref to login with : `' . $this->userModel->login($data['user_ref'])['unique_key'] . '`'
          ]);
        }
      } else {
        echo json_encode(['Error' => "Registered Failled"]);
      }
    }
  }

  public function login()
  {

    header("Access-Control-Allow-Methods: POST");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, 513);

      $unique_key = $_POST['user_ref'];

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
    header("Access-Control-Allow-Methods: POST");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if ($this->reservationModel->getHallId($res_id)) {
        $hall_id = $this->reservationModel->getHallId($res_id);
        if ($this->reservationModel->delete($res_id)) {
          if ($this->reservationModel->decreaseCapacity($hall_id)) {
            echo json_encode(["Success" => "Deleted With Success"]);
          }
        } else {
          echo json_encode(["Error" => "You can only cancel reservations that are at least one day before the show date"]);
        }
      }
    }
  }

  public function my_reservations()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, 513);
      $user_ref = $_POST['user_ref'];

      if ($this->reservationModel->getAll($user_ref)) {
        echo json_encode($this->reservationModel->getAll($user_ref));
      } else {
        echo json_encode(["None" => "You have no reservations yet"]);
      }
    } else {
      echo json_encode(["Error" => "404 ERROR"]);
    }
  }
}
