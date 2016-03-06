<?php

/**
 * Created by PhpStorm.
 * User: Eklect
 * Date: 3/5/2016
 * Time: 10:22 AM
 */
class Helper {

    public function listAllMethods($controller_name) {

        /* Get All The Methods of This Controller */
        $action_array = get_class_methods($controller_name);
        /* Filter out anything that isn't an Action Method */
        $action_array = array_filter($action_array, function ($val) {

            if (!preg_match('/Action/', $val) || preg_match('/index/i', $val)) {
                return false;
            } else {
                return true;
            }
        });
        /*Remove the word "Action" */
        $action_array = preg_replace('/Action/', '', $action_array);
        /*Sort the Array Alphabetically */
        sort($action_array);

        return $action_array;

    }
}