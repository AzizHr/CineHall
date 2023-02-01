<?php
class Films extends Controller
{

  private $filmModel;

  public function __construct()
  {
    $this->filmModel = $this->model('Film');
  }

  public function films()
  {
    echo json_encode($this->filmModel->getAll());
  }

  public function film_info($film_id)
  {
    $filmInfo = $this->filmModel->getSingle($film_id);

    if ($filmInfo) {
      echo json_encode($filmInfo);
    } else {
      echo json_encode(["Error" => "404 ERROR"]);
    }
  }
}
