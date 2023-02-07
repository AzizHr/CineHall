<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // header("Access-Control-Allow-Methods: *");
class Movies extends Controller
{

  private $movieModel;

  public function __construct()
  {

    $this->movieModel = $this->model('Movie');
  }

  public function movies()
  {
    header("Access-Control-Allow-Methods: GET");
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($this->movieModel->getAll());
  }

  public function movie_info($film_id)
  {
    
    $movie_info = $this->movieModel->getSingle($film_id);

    if ($movie_info) {
      echo json_encode($movie_info);
    } else {
      echo json_encode(["Error" => "404 ERROR"]);
    }
  }

  public function reserved_seats($movie_id) {
    if($this->movieModel->getMovieReservedSeats($movie_id)) {
      echo json_encode($this->movieModel->getMovieReservedSeats($movie_id));
    } else {
      echo json_encode(["Error" => "404 ERROR"]);
    }
  }
}
