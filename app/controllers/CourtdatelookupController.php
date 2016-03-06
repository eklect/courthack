<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 3/5/16
 * Time: 7:49 AM
 */
use Phalcon\Mvc\Controller;

class CourtdatelookupController extends Controller {

    public static $link_name = 'Court Date Lookup';

    public function indexAction() {

        $courtCases = CourtDateLookup::find();
        $this->view->setVar("courtCases", $courtCases);

    }

    public function deleteAction() {
        $params = $this->dispatcher->getParams();
        $entry = CourtDateLookup::findFirst(array("conditions" => "court_case_id = ?1", "bind" => array(1 => $params[0])));
        if ($entry != false) {
            if ($entry->delete() == false) {
                echo $entry->getMessages() . "\n";
            }
            $this->response->redirect('/courtdatelookup');
        }

    }
}