<?php

use Phalcon\Mvc\Controller;

class FilecaseController extends Controller {
    public static $link_name= 'File Case';

    public function indexAction() {
    }

    public function filecaseAction() {

        if($this->request->isPost() == true) {
            $user_id = $this->session->get("user_id");
            $case_type = $this->request->get("case_type");
            $description = $this->request->get("description");
            echo "hello";
            $caseFile = new FileCase();
            $caseFile->user_id = $user_id;
            $caseFile->case_type = $case_type;
            $caseFile->description = $description;
            if($caseFile->save() == false) {
                echo $caseFile->getMessages();
            }

            $this->response->redirect('/filecase/show');
        }
    }

    public function showAction() {
        $cases = FileCase::find(array("conditions" => "user_id = ?1", "bind" => array(1 => $this->session->get("user_id"))));

        $this->view->setVar("cases", $cases);
    }

    public function deleteAction() {
        $params = $this->dispatcher->getParams();
        $entry = FileCase::findFirst(array("conditions" => "case_id = ?1", "bind" => array(1 => $params[0])));
        if ($entry != false) {
            if ($entry->delete() == false) {
                echo $entry->getMessages() . "\n";
            }
            $this->response->redirect('/filecase/show');
        }
    }
}
