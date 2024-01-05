<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class InstallmentController extends BaseController
{

    use ResponseTrait;
    public function get_remaining_amount()
    {
        $session = session();

        if (!$session->has('is_customer_logged_in')) {
            // User is not logged in, redirect to login page
            return redirect()->to('');
        }
        try {
            $customer_id = $session->get('cust_id');
            $db = db_connect();
            // get purchases of customer
            $sql = "SELECT * FROM `purchase` WHERE `user_id` = $customer_id and `purchase_status` = 'pending'";
            $query = $db->query($sql);
            $purchases = $query->getResultArray();
            $remaining_amount = 0;
            foreach ($purchases as $purchase) {
                $sql = "SELECT * FROM `installment` WHERE `purchase_id` = $purchase[purchase_id]";
                $query = $db->query($sql);
                $installments = $query->getResultArray();

                $i = 0;
                foreach ($installments as $installment) {
                    if ($installment['installment_status'] == 'pending'){
                        $remaining_amount += $installment['amount_due'];
                        break;
                    }
                    $i++;
                };
            }
            return $remaining_amount;
        } catch (\Exception $e) {
            return $this->$e->getMessage();
        }
    }
}
