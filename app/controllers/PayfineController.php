<?php
use Phalcon\Mvc\Controller;

class PayfineController extends Controller {

    public static $link_name= 'Payments';

    public function indexAction() {
        //$ticket_id = $this->dispatcher->getParams()[0];
        $tickets    = PayFine::find(array("conditions" => "user_id = ?1", "bind" => array(1 => $this->session->get("user_id"))));
        $this->view->setVar("tickets", $tickets);
    }

    public function protestAction() {
        $ticket_id = $this->dispatcher->getParams()[0];
        $this->view->setVar("ticket_id", $ticket_id);
        //$ticket_id = $this->request->get("ticket_id");
        //$user_id = $this->session->get("user_id");


    }

    public function saveAction() {
        echo "INSIDE SAVEACTION";
            $description = $this->request->get("description");
            $ticket_id = $this->dispatcher->getParam("ticket_id");

            $protest = new Protests();
            $protest->ticket_id = $ticket_id;
            $protest->user_id = $this->session->get("user_id");
            $protest->description = $description;
            $protest->status = "Protest Pending";
            $protest->reviewer_id = 2;

            if($protest->save() == true) {
                $ticket = PayFine::findFirst(array("conditions" => "ticket_id = ?1 AND user_id = ?2", "bind" => array(1 => $ticket_id, 2 => $this->session->get("user_id"))));
                $ticket->status = "Protest Pending";
                $ticket->save();
            }
            else {
                echo $protest->getMessages();
            }

            $this->response->redirect('/payfine');
    }

    public function findticketAction() {
        /*
        $ticket_id = $this->dispatcher->getParams()[0];
        $ticket    = PayFine::findFirst(array("conditions" => "ticket_id = ?1 AND user_id = ?2", "bind" => array(1 => $ticket_id, 2 => $this->session->get("user_id"))));
        $this->view->setVar("ticket", $ticket);
        */
    }
}
