<?php

class Clients extends Controller
{
  private $clientModel;
  private $reservationModel;

  public function __construct()
  {
    headerHelper();
    $this->clientModel = $this->model('Client');
    $this->reservationModel = $this->model('Reservation');
  }

  public function register()
  {
    postHelper();
    $client_info = [
      'ref' => bin2hex(random_bytes(4)),
      'first_name' => $_POST['first_name'],
      'last_name' => $_POST['last_name']
    ];

    if (requestMethod() == 'POST') {
      if ($this->clientModel->register($client_info)) {
        if ($this->clientModel->login($client_info['ref'])) {
          echo json_encode([
            'Success' => "Registered With Success",
            'Ref' => 'Here is your ref to login with : `' . $this->clientModel->login($client_info['ref'])->ref . '`'
          ]);
        }
      } else {
        echo json_encode(['Error' => "Registration failed"]);
      }
    }
  }

  public function auth()
  {
    postHelper();
    if (requestMethod() == 'POST') {

      $ref = $_POST['ref'];

      if (empty($ref)) {
        echo json_encode(["Error" => "Please enter your ref"]);
      } else {
        $loggedInClient = $this->clientModel->login($ref);

        if ($loggedInClient) {
          echo json_encode($loggedInClient);
        } else {
          echo json_encode(0);
        }
      }
    }
  }

  public function book()
  {
    postHelper();
    if (requestMethod() == 'POST') {
      $info = [
        'hall_id_fk' => $_POST['hall_id_fk'],
        'movie_id_fk' => $_POST['movie_id_fk'],
        'client_id_fk' => $_POST['client_id_fk'],
        'seat_number' => $_POST['seat_number']
      ];

      if ($this->reservationModel->store($info)) {
        echo json_encode(['Success' => 'Booked with success']);
      } else {
        echo json_encode(['Error' => 'You can\'t book the same seat twice']);
      }
    }
  }

  public function my_reservations()
  {
    postHelper();
    if (requestMethod() == 'POST') {
      $ref = $_POST['client_ref'];
      if ($this->reservationModel->allClientReservations($ref)) {
        echo json_encode($this->reservationModel->allClientReservations($ref));
      } else {
        echo json_encode(["Unfound" => "You do not have any reservations yet"]);
      }
    }
  }

  public function cancel($id)
  {
    getHelper();
    if ($this->reservationModel->drop($id)) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }
  }
}
