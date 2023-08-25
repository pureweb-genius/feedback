<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

    public function loginAction() {
        if (!empty($_POST)) {
            if (!$this->model->validate($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->redirect('review');
        }
        $this->view->render('Вход');
    }

    public function logoutAction()
    {
        session_destroy();
        $this->view->redirect('/feedback/');
    }



}