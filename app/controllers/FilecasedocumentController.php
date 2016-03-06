<?php
use Phalcon\Mvc\Controller;

class FilecasedocumentController extends Controller {

    public static $link_name = 'File Case Documents';
    public        $sub_nav;

    public function initialize() {

        $h             = new Helper();
        $this->sub_nav = $h->listAllMethods(__CLASS__);

    }

    public function indexAction() {

        $this->view->setVar('sub_nav', $this->sub_nav);
    }

    public function uploadAction() {

        if ($this->request->isPost() == true) {
            if ($this->request->hasFiles() == true) {
                $user = $this->request->get("username");
                foreach ($this->request->getUploadedFiles() as $file) {
                    $file->moveTo('../app/files/' . $user . '/' . $file->getName());
                    $fileDocument            = new FileCaseDocument();
                    $fileDocument->user_id   = $this->session->get("user_id");
                    $fileDocument->filename  = $file->getName();
                    $fileDocument->file_path = "../app/files/" . $user . "/";
                    if ($fileDocument->save() == false) {
                        echo $fileDocument->getMessages(), "\n";
                    }
                }
            }
        }
    }

    public function deleteAction() {

        $params = $this->dispatcher->getParams();
        $entry  = FileCaseDocument::findFirst(array("conditions" => "id = ?1", "bind" => array(1 => $params[0])));
        if ($entry != false) {
            if ($entry->delete() == false) {
                echo $entry->getMessages() . "\n";
            }
            $this->response->redirect('/filecasedocument/list');
        }
    }

    public function listAction() {

        $user    = $this->session->get("user_id");
        $entries = FileCaseDocument::find(array("conditions" => "user_id = ?1", "bind" => array(1 => $user)));
        $this->view->setVar("entries", $entries);

    }
}
