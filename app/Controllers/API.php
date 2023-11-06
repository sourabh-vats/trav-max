<?php

namespace App\Controllers;

class API extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->is_customer_logged_in) {
            header('Location: /');
            die();
        }
    }

    public function get_partnership()
    {
        $db = db_connect();
        $query = $db->query('select * from partnership where user_id = "' . $_POST["userId"] . '"');
        $row = $query->getRowArray();
        if ($row != null) {
            $data = [
                'status' => "success",
                'data' => $row,
            ];
        } else {
            $data = [
                'status' => "fail",
                'data' => "No partnership found for the user.",
            ];
        }

        return $this->response->setJSON($data);
    }

    public function set_partnership()
    {
        $session = session();
        $userId = $session->get("cust_id");

        $db = db_connect();
        $query = $db->query('select * from partnership where user_id = "' . $userId . '"');
        $row = $query->getRowArray();
        if ($row != null) {
            $query = $db->query('UPDATE `partnership` SET `package_id` = "' . $_POST["packageId"] . '", `type` = "' . $_POST["partnership"] . '", `plan` = "' . $_POST["plan"] . '" WHERE (`user_id` = "' . $userId . '")');
            if ($query) {
                $data = [
                    'status' => "success",
                    'data' => $query,
                ];
            } else {
                $data = [
                    'status' => "fail",
                    'data' => "Some error happend can't update data.",
                ];
            }
        } else {
            $query = $db->query('insert into partnership (`user_id`, `package_id`, `type`, `plan`) VALUES ("' . $userId . '","' . $_POST["packageId"] . '", "' . $_POST["partnership"] . '", "' . $_POST["plan"] . '")');
            if ($query) {
                $data = [
                    'status' => "success",
                    'data' => $query,
                ];
            } else {
                $data = [
                    'status' => "fail",
                    'data' => "Some error happend can't insert data.",
                ];
            }
        }

        return $this->response->setJSON($data);
    }
}
