<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class ReviewController extends Controller
{

    public function indexAction()
    {
       $this->view->render('Отзывы');
    }

    public function storeAction()
    {
        return $this->model->store($_POST);
    }

    public function loadAction()
    {
        $reviews = $this->model->sortBy($_GET['sortBy']);
        $response = array("success" => true, "reviews" => $reviews);

       echo  json_encode($response);
    }

    public function deleteAction()
    {
        $this->model->delete($_POST['id']);
        $response = array("success" => true, "message" => "Отзыв успешно удален.");

        echo json_encode($response);
    }

    public function updateAction()
    {
        $this->model->update($_POST);
        $response = array("success" => true, "message" => "Отзыв успешно обновлен.");

        echo json_encode($response);
    }
}