<?php

/**
 * Created by PhpStorm.
 * User: Eklect
 * Date: 3/5/2016
 * Time: 1:47 AM
 */
class LoginController extends \Phalcon\Mvc\Controller {

    public function indexAction() {

    }

    public function loginAction() {
        
        $data     = $this->request->getPost();
        $username = $data['username'];
        $record   = Users::findFirst(array('conditions' => 'username=?1', 'bind' => array(1 => $username)));
        $verified = password_verify($data['password'], $record->password);
        if (!empty($record) && !empty($verified)) {
            $this->session->set('logged_in', 1);
            $this->session->set('user_id', $record->id);
            $this->response->redirect('/');
        } else {
            $this->flash->error('Wrong Creds');
        }
    }

    public function logoutAction() {

        $this->session->destroy();
        $this->response->redirect('/');
    }

    public function setPasswordAction() {

        $pw = $this->dispatcher->getParams()[0];
        $this->view->disable();
        echo password_hash($pw, PASSWORD_DEFAULT);

    }

    public function getUserSessionAction() {

        $this->view->disable();
        var_dump($this->session->get());
    }
}
