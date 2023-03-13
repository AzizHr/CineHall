<?php

class Movies extends Controller
{

  private $movieModel;

  public function __construct()
  {
    headerHelper();
    $this->movieModel = parent::model('Movie');
  }

  public function index()
  {
    getHelper();
    echo json_encode($this->movieModel->allMovies());
  }

  public function show($shown_at)
  {
    getHelper();
    if ($this->movieModel->singleMovie($shown_at)) {
      echo json_encode($this->movieModel->singleMovie($shown_at));
    } else {
      echo json_encode(["Unfound" => "Could not found any movie with id {$shown_at}"]);
    }
  }

  public function filter($show_at)
  {
    if ($this->movieModel->filter($show_at)) {
      echo json_encode($this->movieModel->filter($show_at));
    } else {
      echo json_encode(0);
    }
  }

  public function reserved_seats($shown_at)
  {
    if($this->movieModel->reserved_seats($shown_at))
    {
      echo json_encode($this->movieModel->reserved_seats($shown_at));
    }
  }

  // public function shown_at($movie_id_fk)
  // {
  //   if($this->movieModel->allShownAtDates($movie_id_fk))
  //   {
  //     echo json_encode($this->movieModel->allShownAtDates($movie_id_fk));
  //   }
  // }

  // public function shown_in($movie_id_fk)
  // {
  //   if($this->movieModel->allHalls($movie_id_fk))
  //   {
  //     echo json_encode($this->movieModel->allHalls($movie_id_fk));
  //   }
  // }

  // public function get_movie()
  // {
  //   postHelper();
  //   if(requestMethod() == 'POST')
  //   {
  //     $info = [
  //       'movie_id_fk' => $_POST['movie_id_fk'],
  //       // 'hall_id_fk'  => $_POST['hall_id_fk'],
  //       'shown_at'    => $_POST['shown_at']
  //     ];

  //     if($this->movieModel->get_movie($info))
  //     {
  //       echo json_encode($this->movieModel->get_movie($info));
  //     }
  //   }
  // }
}
