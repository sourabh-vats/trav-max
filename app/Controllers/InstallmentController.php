<?php

namespace App\Controllers;

use Exception;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;

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
                    if ($installment['installment_status'] == 'pending') {
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

    public function get_remaining_payment()
    {
        $session = session();

        if (!$session->has('is_customer_logged_in')) {
            // User is not logged in, redirect to login page
            return redirect()->to('');
        }
        try {
            $customer_id = $session->get('cust_id');
            $db = db_connect();

            // get membership of customer
            $sql = "SELECT * FROM `partnership` WHERE `user_id` = $customer_id";
            $query = $db->query($sql);
            $membership = $query->getRowArray();

            // Calculate number of installments required for booking amount
            $number_of_booking_installments = 1;
            if ($membership['plan'] == 'traveasy_plan') {
                $number_of_booking_installments = 2;
            }

            // get purchases of customer
            $sql = "SELECT * FROM `purchase` WHERE `user_id` = $customer_id and `purchase_type` = 'membership'";
            $query = $db->query($sql);
            $purchases = $query->getResultArray();

            if ($number_of_booking_installments == 1) {
                $purchase_id = $purchases[0]['purchase_id'];
                $sql = "SELECT * FROM `installment` WHERE `purchase_id` = $purchase_id order by installment_id ASC limit 1";
                $query = $db->query($sql);
                $installments = $query->getResultArray();
            } else {
                $purchase_id = $purchases[1]['purchase_id'];
                $sql = "SELECT * FROM `installment` WHERE `purchase_id` = $purchase_id order by installment_id ASC limit 2";
                $query = $db->query($sql);
                $installments = $query->getResultArray();
            }

            $remaining_amount = 0;
            foreach ($installments as $installment) {
                if ($installment['installment_status'] == 'pending') {
                    $remaining_amount += $installment['amount_due'];
                    break;
                }
            }

            $number_of_purchases = count($purchases);
            $remaining_amount = $remaining_amount * $number_of_purchases;
            $type = 'booking';

            if ($remaining_amount == 0) {
                // get first unpaid installment of first unpaid purchase
                $sql = "SELECT * FROM `purchase` WHERE `user_id` = $customer_id and `purchase_status` = 'pending'";
                $query = $db->query($sql);
                $purchases = $query->getResultArray();
                $remaining_amount = 0;
                $sql = "SELECT * FROM `installment` WHERE `purchase_id` = $purchases[0]['purchase_id'] and `installment_status` = 'pending' order by installment_id ASC limit 1";
                $query = $db->query($sql);
                $installment = $query->getResultArray();
                if ($installment) {
                    $remaining_amount = $installment['amount_due'];
                    $type = 'installment';
                } else {
                    $type = 'none';
                }
            }

            return $this->respond(
                [
                    'status' => 200,
                    'message' => 'success',
                    'data' => [
                        'type' => $type,
                        'remaining_amount' => $remaining_amount
                    ]
                ]
            );
        } catch (DatabaseException $e) {
            return $this->fail($e->getMessage());
        } catch (\Exception $e) {
            return $this->$e->getMessage();
        }
    }
}
