<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller {

  public function indexAction() {
    if (!$this->session->has('logged_in')) {
      $this->view->setMainView('front');
    }
  }
}
