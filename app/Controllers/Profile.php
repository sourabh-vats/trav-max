<?php

namespace App\Controllers;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Profile extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->is_customer_logged_in) {
            header('Location: /');
            die();
        }
    }

    public function index()
    {
        $data['page_keywords'] = '';
        $data['page_description'] = '';
        $data['page_slug'] = 'Dashboard';
        $data['page_title'] = 'Dashboard';

        $session = session();
        $user_model = model('UserModel');
        $id = $session->cust_id;
        $customer_id = $session->trav_id;
        $data['profile'] = $user_model->profile($id);
        $data['total_income'] = (int)$user_model->get_total_income($id);
        $data['pending_income'] = (int)$user_model->get_pending_income($id);
        $data['approved_income'] = (int)$user_model->get_approved_income($id);
        $data['redeemed_income'] = (int)$user_model->get_redeemed_income($id);
        $data['amount_paid'] = (int)$user_model->get_amount_paid($id);
        $data['amount_remaining'] = (int)$user_model->get_amount_remaining($id);
        $data['installments_paid'] = (int)$user_model->get_installments_paid($id);
        $data['installments_remaining'] = (int)$user_model->get_installments_remaining($id);
        $data['installments_total'] = $data['installments_paid'] + $data['installments_remaining'];
        $data['has_package'] = false;
        $data['package_information'] = $user_model->get_package($id);
        //$data['status'] = $user_model->status($id);

        if (empty($data['package_information'])) {
            $data['has_package'] = false;
        } else {
            $data['has_package'] = true;
        }

        $team = array();
        $ids = array($customer_id);
        $p = 0;
        while ($p < 1) {
            $myfriends = $user_model->my_friends_in($ids);
            if (!empty($myfriends)) {
                $team = array_merge($team, $myfriends);
                $ids = array_column($myfriends, 'customer_id');
            } else {
                $p++;
            }
        }
        $data['total_partner'] = $team;
        $data['total_partners'] = count($team);

        //calculate sales and income
        $my_sales = 0;
        $team_sales = 0;
        $active_income = 0;
        $team_income = 0;
        for ($i = 0; $i < count($team); $i++) {
            if ($team[$i]["parent_customer_id"] == $customer_id) {
                $number_of_installments_paid = (int)$user_model->get_installments_paid($team[$i]["id"]);
                if ($number_of_installments_paid > 0) {
                    $my_sales++;
                    $income_from_this_partner = (int)$user_model->get_income_from_this_partner($id, $team[$i]["id"]);
                    $active_income += $income_from_this_partner;
                }
            } else {
                $number_of_installments_paid = (int)$user_model->get_installments_paid($team[$i]["id"]);
                if ($number_of_installments_paid > 0) {
                    $team_sales++;
                    $income_from_this_partner = (int)$user_model->get_income_from_this_partner($id, $team[$i]["id"]);
                    $team_income += $income_from_this_partner;
                }
            }
        }
        $data["my_sales"] = $my_sales;
        $data["team_sales"] = $team_sales;
        $data["total_sales"] = $my_sales + $team_sales;
        $data["active_income"] = $active_income;
        $data["team_income"] = $team_income;

        $data["package_data"] = "";
        $db = db_connect();
        $query = $db->query('SELECT SUM(amount) as total FROM `incomes` WHERE user_id = ' . $id . ' and status = "Approved" and pay_type = "travmoney"');
        $row = $query->getRow();
        $data['travmoney'] = $row->total;
        $query = $db->query('SELECT SUM(amount) as total FROM `incomes` WHERE user_id = ' . $id . ' and status = "Approved" and pay_type = "travprofit"');
        $row = $query->getRow();
        $data['travprofit'] = $row->total;
        //get balances of different wallets
        $moneyback = $cashback = $reward = $bonus = 0;
        $query = $db->query('SELECT balance FROM `wallet` WHERE user_id = "' . $customer_id . '" and wallet_type = "moneyback"');
        $row = $query->getRow();
        $moneyback = $row->balance;
        $query = $db->query('SELECT balance FROM `wallet` WHERE user_id = "' . $customer_id . '" and wallet_type = "cashback"');
        $row = $query->getRow();
        $cashback = $row->balance;
        $query = $db->query('SELECT balance FROM `wallet` WHERE user_id = "' . $customer_id . '" and wallet_type = "reward"');
        $row = $query->getRow();
        $reward = $row->balance;
        $query = $db->query('SELECT balance FROM `wallet` WHERE user_id = "' . $customer_id . '" and wallet_type = "bonus"');
        $row = $query->getRow();
        $bonus = $row->balance;

        $data["wallet"] = array("moneyback" => $moneyback, "cashback" => $cashback, "reward" => $reward, "bonus" => $bonus);
        // if ($data["profile"][0]["role"] == "micro") {
        //     $data['main_content'] = 'admin/micro_home';
        //     return view('includes/admin/template', $data);
        // } else {
        //     if ($data['has_package']) {
        //         $data["package_data"] = $user_model->get_package_data($data['package_information'][0]['package_id']);
        //     } else {
        //         return redirect()->to('admin/start');
        //     }
        // }
        $query = $db->query('   SELECT I.installment_id, I.due_date, DATEDIFF(I.due_date, CURDATE()) AS days_left, I.amount_due
                                FROM installment I
                                JOIN purchase P ON I.purchase_id = P.purchase_id
                                WHERE   I.installment_status = "pending" 
                                    and I.purchase_id in (select purchase_id from purchase where user_id = ' . $id . ')
                                    and P.user_id = ' . $id . '
                                ORDER BY I.due_date
                                LIMIT 2');
        $result = $query->getResultArray();
       
        $remaining_days = array_column($result, 'days_left');
        $data['remaining_days'] = $remaining_days[1];
        $remaining_days_percentage = $data['remaining_days']/31*100;
        $data['remaining_days_percentage'] = $remaining_days_percentage;
        //$amount_due = $result[0]['amount_due'] + $result[1]['amount_due'];
        $installmentController = new InstallmentController();
        $data['amount_due'] = (int)$installmentController->get_remaining_amount();
        $amount_due_percentage = $data['amount_due']/11000*100;
        $data['amount_due_percentage'] = $amount_due_percentage;
        // var_dump($data['amount_due']);
        // die();
        $data['main_content'] = 'admin/micro_home';
        //$data['main_content'] = 'admin/home';
        return view('includes/admin/template', $data);
    }

    public function start()
    {
        $user_model = model('UserModel');
        $data['page_keywords'] = '';
        $data['page_description'] = '';
        $data['page_slug'] = 'Select Package';
        $data['page_title'] = 'Start Your Journey';
        $data['js'] = '/js/start.js';
        $data['css'] = '/css/start.css';

        $id = session('cust_id');
        $customer_id = session('bliss_id');
        $data['profile'] = $user_model->profile($id);
        $data['has_package'] = false;
        $data['package_information'] = $user_model->get_package($id);

        if (empty($data['package_information'])) {
            $data['has_package'] = false;
        } else {
            $data['has_package'] = true;
            return redirect()->to(base_url() . 'admin');
        }

        $data['main_content'] = 'admin/start';
        return view('includes/admin/template', $data);
    }

    public function select_package()
    {
        $session = session();
        $user_model = model('UserModel');
        $data['page_keywords'] = '';
        $data['page_description'] = '';
        $data['page_slug'] = 'Select Package';
        $data['page_title'] = 'Dashboard';
        $data['js'] = '/js/select_package.js';

        $id = session('cust_id');
        $customer_id = session('bliss_id');
        $data['profile'] = $user_model->profile($id);
        $data['has_package'] = false;
        $data['package_information'] = $user_model->get_package($id);
        if (empty($data['package_information'])) {
            $data['has_package'] = false;
        } else {
            return redirect()->to(base_url('admin'));
        }

        if ($this->request->getMethod() === 'post') {
            $package_id = $this->request->getPost('package_id');
            $payment_type = $this->request->getPost('payment_type');
            $package_data = $user_model->get_package_data($package_id);
            $package_amount = $package_data[0]['total'];
            $data_to_store = [
                'user_id' => $id,
                'package_id' => $package_id,
                'payment_type' => $payment_type,
                'amount_remaining' => $package_amount
            ];
            $return = $user_model->add_user_package($data_to_store);

            $date = date('Y-m-d H:i:s');
            $data_to_store = [
                'role' => 'Macro',
                'package_used' => $date,
                'macro' => 33,
                'consume' => 1,
                'package_amt' => $package_amount
            ];
            $user_model->update_profile($id, $data_to_store);

            if ($payment_type == 'traveasy_plan') {
                $intallment_amount_left = $package_amount;
                $installment_amount = 6600;
                $installment_number = 1;
                $insdate = date('Y-m-d');
                while ($intallment_amount_left > 0) {
                    $pay_date = date('Y-m-d', strtotime('+ 1 month', strtotime($insdate)));
                    $add_installment = [
                        'user_id' => $id,
                        'amount' => $installment_amount,
                        'description' => $insdate,
                        'pay_date' => $pay_date,
                        'installment_no' => $installment_number,
                        'status' => 'Active'
                    ];
                    $user_model->add_installment($add_installment);
                    $insdate = $pay_date;
                    $intallment_amount_left -= 6600;
                    $installment_number += 1;
                    if ($intallment_amount_left > 6600) {
                        $installment_amount = 6600;
                    } else {
                        $installment_amount = $intallment_amount_left;
                    }
                }
            }

            if ($return) {
                return redirect()->to(base_url('admin/package_selected_successfully'));
            } else {
                $session->setFlashdata('flash_message', 'not_updated');
            }
        }

        $data['all_packages'] = $user_model->get_all_packages();

        $data['main_content'] = 'admin/select_package';
        return view('includes/admin/template', $data);
    }

    public function package()
    {
        $user_model = model('UserModel');
        $data['css'] = '/css/package.css';
        $data['js'] = '/js/package.js';

        $id = session()->get('cust_id');
        $customer_id = session()->get('bliss_id');
        $data['profile'] = $user_model->profile($id);

        $package_id = $this->request->getVar('package');
        $data['package_data'] = $user_model->get_package_data($package_id);

        $data['main_content'] = 'admin/package';
        echo view('includes/admin/template', $data);
    }

    public function select_plan()
    {
        $user_model = model('UserModel');
        $data['page_keywords'] = '';
        $data['page_description'] = '';
        $data['page_slug'] = 'Select Plan';
        $data['page_title'] = 'Dashboard';
        $data['js'] = '/js/select_package.js';

        $id = session()->get('cust_id');
        $customer_id = session()->get('trav_id');
        $data['profile'] = $user_model->profile($id);
        $data['has_package'] = false;
        $data['package_information'] = $user_model->get_package($id);
        if (empty($data['package_information'])) {
            $data['has_package'] = false;
        } else {
            $data['has_package'] = true;
            return redirect()->to(base_url('admin'));
        }

        $package_id = $this->request->getVar('package');
        if (empty($package_id)) {
            return redirect()->to(base_url('admin'));
        }

        $data['package_data'] = $user_model->get_package_data($package_id);
        $db = db_connect();
        $query   = $db->query('select booking_packages_number from customer where customer_id = "' . $customer_id . '"');
        $results = $query->getResultArray();
        $booking_packages_number = 1;
        foreach ($results as $row) {
            $booking_packages_number = $row['booking_packages_number'];
        }
        if ($this->request->getMethod() === 'post') {
            $package_id = $this->request->getPost('package_id');
            $payment_type = $this->request->getPost('payment_type');
            $package_data = $user_model->get_package_data($package_id);
            $package_amount = $package_data[0]['total'];
            $data_to_store = array(
                'user_id' => $id,
                'package_id' => $package_id,
                'payment_type' => $payment_type,
                'amount_remaining' => $package_amount
            );
            $return = $user_model->add_user_package($data_to_store);

            $date = date('Y-m-d H:i:s');
            $data_to_store = array('package_used' => $date, 'macro' => 33, 'consume' => 1, 'package_amt' => $package_amount);
            $user_model->update_profile($id, $data_to_store);

            if ($payment_type == "traveasy_plan") {
                $intallment_amount_left = $package_amount;
                $installment_amount = 6600;
                $installment_number = 1;
                $insdate = date('Y-m-d');
                while ($intallment_amount_left > 0) {
                    $pay_date = date('Y-m-d', strtotime("+ 1 month", strtotime($insdate)));
                    $add_installment = array('user_id' => $id, 'amount' => $installment_amount, 'description' => $insdate, 'pay_date' => $pay_date, 'installment_no' => $installment_number, 'status' => 'Active');
                    $user_model->add_installment($add_installment);
                    $insdate = $pay_date;
                    $intallment_amount_left -= 6600;
                    $installment_number += 1;
                    if ($intallment_amount_left > 6600) {
                        $installment_amount = 6600;
                    } else {
                        $installment_amount = $intallment_amount_left;
                    }
                }
            }
            if ($return == TRUE) {
                return redirect()->to(base_url('admin/package_selected_successfully'));
            } else {
                session()->setFlashdata('flash_message', 'not_updated');
            }
        }
        $data['booking_packages_number'] = $booking_packages_number;
        $data['all_packages'] = $user_model->get_all_packages();

        $data['main_content'] = 'admin/select_plan';
        return view('includes/admin/template', $data);
    }

    public function confirm_plan()
    {
        $user_model = model('UserModel');
        $session = session();
        $data['page_keywords'] = '';
        $data['page_description'] = '';
        $data['page_slug'] = 'Confirm Plan';
        $data['page_title'] = 'Dashboard';
        $data['css'] = '/css/confirm_plan.css';
        $data['js'] = '/js/confirm_plan.js';

        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);

        $package_id = $this->request->getGet('package');
        $payment_plan = $this->request->getGet('plan');
        $payment_amount = 0;
        $data['package_data'] = $user_model->get_package_data($package_id);

        $db = db_connect();
        $query   = $db->query('select booking_packages_number from customer where customer_id = "' . $customer_id . '"');
        $result = $query->getRowArray();
        $booking_packages_number = $result['booking_packages_number'];

        if ($payment_plan == 'traveasy_plan') {
            $payment_amount = 5500 * $booking_packages_number;
        } elseif ($payment_plan == 'travlater_plan') {
            $payment_amount = 11000 * $booking_packages_number;
        } elseif ($payment_plan == 'travnow_plan') {
            $payment_amount = $data['package_data'][0]['total'] * $booking_packages_number;
        }
        $data['payment_amount'] = $payment_amount;

        if ($this->request->getMethod() === 'post') {
            $package_id = $this->request->getPost('package_id');
            $payment_type = $this->request->getPost('payment_type');
            $package_data = $user_model->get_package_data($package_id);
            $package = $package_data[0];
            if ($package["name"] == "Goa") {
                $package_amount_with_tax = $package["total"] + ($package["total"] * 0.05);
            } else {
                $package_amount_with_tax = $package["total"] + ($package["total"] * 0.05) + ($package["total"] * 0.05);
            }
            //Add packages to user in purchase table
            for ($i = 1; $i <= $booking_packages_number; $i++) {
                $add_purchase_data = [
                    'customer_id' => $customer_id,
                    'type' => 'package',
                    'item_id' => $package_id,
                    'purchase_date' => date('d-M-Y H:i:s'),
                    'purchase_price' => $package_amount_with_tax,
                    'status' => 'booked',
                ];
                $query = $db->table('purchase')->insert($add_purchase_data);
                $purchase_id = $db->insertID();
                //installments
                if ($payment_type == 'traveasy_plan') {
                    $intallment_amount_left = $package_amount_with_tax;
                    $installment_amount = 6600;
                    $installment_number = 1;
                    $insdate = date('Y-m-d');
                    while ($intallment_amount_left > 0) {
                        $pay_date = date('Y-m-d', strtotime("+ 1 month", strtotime($insdate)));
                        $add_installment = [
                            'user_id' => $id,
                            'amount' => $installment_amount,
                            'description' => $insdate,
                            'pay_date' => $pay_date,
                            'installment_no' => $installment_number,
                            'status' => 'Active'
                        ];
                        $user_model->add_installment($add_installment);
                        $insdate = $pay_date;
                        $intallment_amount_left -= 6600;
                        $installment_number += 1;
                        if ($intallment_amount_left > 6600) {
                            $installment_amount = 6600;
                        } else {
                            $installment_amount = $intallment_amount_left;
                        }
                    }
                } elseif ($payment_type == 'travnow_plan') {
                    $intallment_amount_left = $package_amount_with_tax;
                    $installment_amount = $package_amount_with_tax;
                    $installment_number = 1;
                    $insdate = date('Y-m-d');
                    $pay_date = date('Y-m-d');
                    $add_installment = [
                        'user_id' => $id,
                        'amount' => $installment_amount,
                        'description' => $insdate,
                        'pay_date' => $pay_date,
                        'installment_no' => $installment_number,
                        'status' => 'Active'
                    ];
                    $user_model->add_installment($add_installment);
                } elseif ($payment_type == 'travlater_plan') {
                    $intallment_amount_left = $package_amount_with_tax;
                    $installment_amount = 11000;
                    $installment_number = 1;
                    $insdate = date('Y-m-d');
                    $pay_date = date('Y-m-d');
                    $add_installment = [
                        'user_id' => $id,
                        'amount' => $installment_amount,
                        'description' => $insdate,
                        'pay_date' => $pay_date,
                        'installment_no' => $installment_number,
                        'status' => 'Active',
                        'order_id' => $purchase_id
                    ];
                    $user_model->add_installment($add_installment);
                    $insdate = $pay_date;
                    $intallment_amount_left -= 11000;
                    $installment_number += 1;
                    if ($intallment_amount_left > 5500) {
                        $installment_amount = 5500;
                    } else {
                        $installment_amount = $intallment_amount_left;
                    }
                    $installment_amount = 5500;
                    while ($intallment_amount_left > 0) {
                        $pay_date = date('Y-m-d', strtotime("+ 1 month", strtotime($insdate)));
                        $add_installment = [
                            'user_id' => $id,
                            'amount' => $installment_amount,
                            'description' => $insdate,
                            'pay_date' => $pay_date,
                            'installment_no' => $installment_number,
                            'status' => 'Active',
                            'order_id' => $purchase_id
                        ];
                        $user_model->add_installment($add_installment);
                        $insdate = $pay_date;
                        $intallment_amount_left -= 5500;
                        $installment_number += 1;
                        if ($intallment_amount_left > 5500) {
                            $installment_amount = 5500;
                        } else {
                            $installment_amount = $intallment_amount_left;
                        }
                    }
                }
            }

            //Need to delete this and update changes as required.
            $data_to_store = [
                'user_id' => $id,
                'package_id' => $package_id,
                'payment_type' => $payment_type,
                'amount_remaining' => $package_amount_with_tax
            ];
            $return = $user_model->add_user_package($data_to_store);

            if ($return == true) {
                return redirect()->to(base_url('admin/package_selected_successfully'));
            } else {
                $session->setFlashdata('flash_message', 'not_updated');
            }
        }

        $data['main_content'] = 'admin/confirm_plan';
        return view('includes/admin/template', $data);
    }

    public function package_selected_successfully()
    {
        $user_model = model('UserModel');
        $data['page_keywords'] = '';
        $data['page_description'] = '';
        $data['page_slug'] = 'Select Package';
        $data['page_title'] = 'Dashboard';

        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);
        
        $db = db_connect();
        $sql = "select p.total, p.name , pr.type, pr.plan from package p
                inner join partnership pr on pr.package_id = p.id
                where pr.user_id = $id ;";
        $query = $db->query($sql)->getResultArray();
        $result = $query[0];

        $data['total'] = $result['total'];
        $data['package_name'] = $result['name'];
        $data['type'] = $result['type'];
        $data['plan'] = $result['plan'];
        $data['booking_packages_number'] = (int)substr($result['type'], -2, -1);
        $data['payment_amount'] = $result['total'] * $data['booking_packages_number'];

        $installmentController = new InstallmentController();
        $data['amount_due'] = (int)$installmentController->get_remaining_amount();

        $data['main_content'] = 'admin/package_selected_successfully';
        return view('includes/admin/template', $data);
    }

    public function request_fund()
    {
        $user_model = model('UserModel');
        $id = session()->get('cust_id');
        $customer_id = session()->get('bliss_id');

        $data['image_error'] = 'false';

        $cimage = '';
        $neft = $this->request->getPost('neft');
        if ($this->request->getMethod() === 'post') {

            $validationRules = [
                'amount' => 'required',
            ];

            $validationMessages = [
                'amount' => [
                    'required' => 'The amount field is required.',
                ],
            ];

            if ($this->validate($validationRules, $validationMessages)) {
                $image = '';
                // file upload start here
                $imageFile = $this->request->getFile('image');
                if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                    $imageFile->move(ROOTPATH . 'public/assets/images');
                    $image = $imageFile->getName();
                } else {
                    $errors = $imageFile->getErrorString() . ' (' . $imageFile->getError() . ')';
                    $image = '';
                }
                //----- end file upload --------------//

                $db = db_connect();
                $sql = "insert into payment_proof (user_id, amount, proof_file_path) values ($id, " . $this->request->getPost('amount') . ", '" . $image . "');";
                $query = $db->query($sql);

                if ($query) {
                    session()->setFlashdata('flash_message', 'updated');
                    return redirect()->to('/admin/request-fund');
                } else {
                    session()->setFlashdata('flash_message', 'not_updated');
                }
            }
        }

        if (!empty($_GET['type']) && $_GET['type'] == "installment") {
            $data['payment_amount'] = $user_model->get_payment_amount($id);
        }

        $data['profile'] = $user_model->profile($id);

        $db = db_connect();
        $sql = "select p.total, p.name , pr.type, pr.plan from package p
                inner join partnership pr on pr.package_id = p.id
                where pr.user_id = $id ;";
        $query = $db->query($sql)->getResultArray();
        $result = $query[0];
        
        $data['main_content'] = 'admin/request_fund';
        return view('includes/admin/template', $data);
    }

    public function kyc()
    {
        $userModel = model('UserModel'); 
        $session = session();
        $validation = \Config\Services::validation();
        $id = $session->get('cust_id');
        $customer_id = $session->get('bliss_id');
    
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'pancard' =>'regex_match[/[A-Z]{5}[0-9]{4}[A-Z]{1}$/]' ,
                'aadhar' =>'regex_match[/^\d{4}\s\d{4}\s\d{4}$/]' ,
                'bank_name' => 'required|trim',
                'account_name' => 'required',
                'account_no' => 'required|trim|regex_match[/^\d{9,18}$/]',
                'ifsc' => 'required'
            ];
    
            if ($this->validate($rules)) {
                $applied_pan='no';
                $panimage = '';
                $uploadConfig = [
                    'path' => WRITEPATH . 'images/user/', 
                    'allowedTypes' => 'gif|jpg|png|jpeg',
                    'maxSize' => 1024
                ];
                $file = $this->request->getFile('panimage');
                $applied_pan=$this->request->getPost('applied_pan');
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move($uploadConfig['path'], $file->getName())) {
                        $panimage = $file->getName();
                    }
                }
                $applied_aadhar='no';
                $aadharimage = '';
                $uploadConfig = [
                    'path' => WRITEPATH . 'images/user/', 
                    'allowedTypes' => 'gif|jpg|png|jpeg',
                    'maxSize' => 1024 
                ];
                $file = $this->request->getFile('aadharimage');
                $applied_aadhar=$this->request->getPost('applied_aadhar');

                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move($uploadConfig['path'], $file->getName())) {
                        $aadharimage = $file->getName();
                    }
                }

                $cheque_img = '';
                $uploadConfig = [
                    'path' => WRITEPATH . 'images/user/', 
                    'allowedTypes' => 'gif|jpg|png|jpeg',
                    'maxSize' => 1024 
                ];
                $file = $this->request->getFile('cheque_img');
    
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move($uploadConfig['path'], $file->getName())) {
                        $cheque_img = $file->getName();
                    }
                }
                $var_status='no';
                $var_status=$this->request->getPost('var_status');

                $dataToStore = [
                    'pancard' => $this->request->getPost('pancard'),
                    'applied_pan' => $applied_pan,
                    'panimage' => $panimage,
                    'aadhar' => $this->request->getPost('aadhar'),
                    'applied_aadhar' => $applied_aadhar,
                    'aadharimage' => $aadharimage,
                    'cheque_img' => $cheque_img,
                    'gender' => $this->request->getPost('gender'),
                    'bank_name' => $this->request->getPost('bank_name'),
                    //'branch' => $this->request->getPost('branch'), 
                    'account_name' => $this->request->getPost('account_name'),
                    //'account_type' => $this->request->getPost('account_type'),  
                    'account_no' => $this->request->getPost('account_no'),
                    //'bank_city' => $this->request->getPost('bank_city'),
                    //'bank_state' => $this->request->getPost('bank_state'), 
                    'ifsc' => $this->request->getPost('ifsc'),
                    'var_status' => $var_status
                ];
    
                $return = $userModel->update_profile($id, $dataToStore); 
    
                if ($return) {
                    $session->setFlashdata('flash_message', 'updated');
                    return redirect()->to(base_url('admin/kyc'));
                } else {
                    $session->setFlashdata('flash_message', 'not_updated');
                }
            } else{
                $errors = $validation->getErrors();
                $value = empty($errors) ? "" : reset($errors);
                $data = array("status" => "error", "message" => $value);
                $session->setFlashdata('flash_message', $value);
                return redirect()->to(base_url('admin/kyc'));
                
            }
        }
    
        $data['profile'] = $userModel->profile($id);
        $data['main_content'] = 'admin/kyc';
        return view('includes/admin/template', $data);
    }
    

    public function installments()
    {
        $user_model = model('UserModel');
        $id = session()->get('cust_id');
        $customer_id = session()->get('trav_id');
        $data['profile'] = $user_model->profile($id);

        $package_number = 0;
        if (!empty($_GET['package'])) {
            $package_number = $_GET['package'];
        }
        $db = db_connect();
        $query = $db->query('SELECT * FROM purchase where customer_id = "' . $customer_id . '" LIMIT ' . $package_number . ',1');
        $row = $query->getRow();
        $purchase_id = $row->id;

        $data['pin'] = $user_model->get_installment($purchase_id);

        $razorpay = 'false';

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'amount' => 'required'
            ];
            $errors = [
                'amount' => [
                    'required' => 'The amount field is required.'
                ]
            ];

            if ($this->validate($rules, $errors)) {
                if ($this->request->getPost('how_to_pay') == 'razorpay') {
                    $status = 'Process';
                } else {
                    $status = 'Pending';
                }

                $data_to_store = [
                    'user_id' => $id,
                    'dis' => 'Installment amount',
                    'cr' => $this->request->getPost('amount'),
                    'qty' => 1,
                    'how_to_pay' => $this->request->getPost('how_to_pay'),
                    'status' => $status,
                ];
                $order_id = $user_model->add_order($data_to_store);

                $razorpay = 'true';
            }
        }

        if ($razorpay == 'true') {
            $data['order_id'] = $order_id;
            $data['order_amt'] = $this->request->getPost('amount');
            $data['oname'] = $data['profile'][0]['f_name'];
            $data['phone'] = $data['profile'][0]['phone'];
            $data['email'] = $data['profile'][0]['email'];
            $data['contst'] = 'Installment';
            $data['returnuri'] = 'admin/installments';
            session()->set('insid', $this->request->getPost('id'));
            $data['main_content'] = 'admin/razorpay';
            return view('includes/admin/template', $data);
        } else {
            $data['main_content'] = 'admin/installment';
            return view('includes/admin/template', $data);
        }
    }

    public function travelcenter()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);
        $db = db_connect();
        $query   = $db->query('
        SELECT  incomes.id, incomes.amount,incomes.rdate,incomes.dist_level, customer.customer_id as user_send_by
        FROM customer
          LEFT JOIN incomes ON customer.id = incomes.user_send_by
        WHERE incomes.user_id = ' . $id . ' and incomes.status = "Approved" and incomes.pay_type = "travmoney";');
        $result = $query->getResultArray();
        $data["travelcenter"] = $result;

        $data['main_content'] = 'admin/travelcenter';
        return view('includes/admin/template', $data);
    }

    public function businesscenter()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);
        $db = db_connect();
        $query   = $db->query('
        SELECT  incomes.id, incomes.amount,incomes.rdate,incomes.dist_level, customer.customer_id as user_send_by
        FROM customer
          LEFT JOIN incomes ON customer.id = incomes.user_send_by
        WHERE incomes.user_id = ' . $id . ' and incomes.status = "Approved" and incomes.pay_type = "travprofit";');
        $result = $query->getResultArray();
        $data["travelcenter"] = $result;

        $data['main_content'] = 'admin/businesscenter';
        return view('includes/admin/template', $data);
    }

    public function mysales()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);

        $team = array();
        $ids = array($customer_id);
        $p = 0;
        while ($p < 1) {
            $myfriends = $user_model->my_friends_in($ids);
            if (!empty($myfriends)) {
                $team = array_merge($team, $myfriends);
                $ids = array_column($myfriends, 'customer_id');
            } else {
                $p++;
            }
        }

        $my_sales = array();
        foreach ($team as $member) {
            if ($member["parent_customer_id"] == $customer_id) {
                array_push($my_sales, $member);
            }
        }
        $data["mysales"] = $my_sales;

        $data['main_content'] = 'admin/mysales';
        return view('includes/admin/template', $data);
    }

    public function teamsales()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);

        $team = array();
        $ids = array($customer_id);
        $p = 0;
        while ($p < 1) {
            $myfriends = $user_model->my_friends_in($ids);
            if (!empty($myfriends)) {
                $team = array_merge($team, $myfriends);
                $ids = array_column($myfriends, 'customer_id');
            } else {
                $p++;
            }
        }

        $team_sales = array();
        foreach ($team as $member) {
            if ($member["parent_customer_id"] != $customer_id) {
                array_push($team_sales, $member);
            }
        }
        $data["teamsales"] = $team_sales;

        $data['main_content'] = 'admin/teamsales';
        return view('includes/admin/template', $data);
    }
    public function profile()
    {
        $id = session()->get('trav_id');
        $session = session();

        if ($this->request->getMethod() === 'post' && isset($_FILES['profile_image'])) {
            $uploadDir = FCPATH . 'images/user_profile/';
            $profileImage = $_FILES['profile_image'];

            $imageFileType = strtolower(pathinfo($profileImage['name'], PATHINFO_EXTENSION));
            if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                $newFileName = $id . '.png';

                if (move_uploaded_file($profileImage['tmp_name'], $uploadDir . $newFileName)) {
                    $session->setFlashdata('flash_message', 'Profile picture updated successfully');
                } else {
                    $session->setFlashdata('flash_message', 'Error uploading the file');
                }
            } else {
                $session->setFlashdata('flash_message', 'Only JPG, JPEG, and PNG files are allowed');
            }
        }
        $data['id'] = $id;
        $data['main_content'] = 'admin/profile';
        return view('includes/admin/template', $data);
    }

    public function update_profile()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $session = session();

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->reset();
            // field name, error message, validation rules
            $validation->setRule('first_name', 'first name', 'trim|required|min_length[3]');
            $validation->setRule('last_name', 'last name', 'trim|required');
            $validation->setRule('email', 'email', 'trim|required|valid_email');

            if (!$validation->run($_POST)) {
                $errors = $validation->getErrors();
                $value = empty($errors) ? "" : reset($errors);
                $session->setFlashdata('flash_message', $value);
            } else if ($_POST['otp'] == "") {
                $otp = random_int(100000, 999999);
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );                                         //Send using SMTP
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.elasticemail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'sourabhvats96@gmail.com';                     //SMTP username
                    $mail->Password   = 'D523B4735BB9E3503EF9C1257E0FBD6AD5BF';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;

                    //Recipients
                    $mail->setFrom('sourabhvats96@gmail.com', 'Travmax');
                    $mail->addAddress($_POST['email']);     //Add a recipient
                    $mail->addReplyTo('info@travmaxholidays.com', 'Information');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'OTP';


                    // Set the view content as the email body
                    $mail->Body = 'OTP for Updating Profile details is this: ' . $otp;
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $data_to_store = [
                    'email' => $_POST['email'],
                    'otp' => $otp
                ];
                $db = db_connect();
                $db->table('otp')->insert($data_to_store);
                $data = array("status" => "error", "message" => "Enter the otp");
                header("Content-Type: application/json");
                echo json_encode($data);
                exit();
            } elseif ($this->request->getPost('otp')) {
                $otp = $this->request->getPost('otp');
                $email = $this->request->getPost('email');
                $firstName = $this->request->getPost('first_name');
                $lastName = $this->request->getPost('last_name');
                $data_to_store = [
                    'f_name' => $firstName,
                    'l_name' => $lastName,
                    'email' => $email
                ];
                $db = db_connect();
                $otpRow = $db->table('otp')
                    ->where('email', $email)
                    ->get()
                    ->getRow();

                if ($otpRow && $otpRow->otp == $otp) {
                    $return = $user_model->update_profile($id, $data_to_store);
                    if ($return == true) {
                        $data = array("status" => "success", "message" => "Account Updated successfully.");
                        header("Content-Type: application/json");
                        echo json_encode($data);
                        exit();
                    }
                } else {
                    $data['status'] = 'error';
                    $data['message'] = 'Invalid OTP';
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    exit();
                }
            }
        }
        $data['profile'] = $user_model->profile($id);
        $data['main_content'] = 'admin/update_profile';
        return view('includes/admin/template', $data);
    }

    public function share_products()
    {
        $user_model = model('UserModel');
        $data = [];
        $id = session('cust_id');
        $data['profile'] = $user_model->profile($id);

        if ($this->request->getMethod() === 'post') {
            $category = $this->request->getPost('selected_category');
            if ($category === 'all') {
                $data['products'] = $user_model->get_all_products();
            } else {
                $data['products'] = $user_model->get_products_by_category($category);
            }
        } else {
            $data['products'] = $user_model->get_all_products();
        }

        $data['main_content'] = 'admin/share_products';
        return view('includes/admin/template', $data);
    }

    public function bonus()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);


        $data['main_content'] = 'admin/bonus';
        return view('includes/admin/template', $data);
    }

    public function reward()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $db = db_connect();
        $data['profile'] = $user_model->profile($id);
        $query = $db->query('   select wt.*, concat(c.f_name, " ", c.l_name) as name from wallet_transaction wt, customer c
                                where wt.wallet_id = (select wallet_id from wallet where user_id = '.$id.' and wallet_type = "reward")
                                and c.id = '.$id.';');
        $row = $query->getResultArray();
        $data['rewards'] = $row;

        $data['main_content'] = 'admin/reward';
        return view('includes/admin/template', $data);
    }

    public function myincome()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);


        $data['main_content'] = 'admin/myincome';
        return view('includes/admin/template', $data);
    }

    public function teamincome()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);


        $data['main_content'] = 'admin/teamincome';
        return view('includes/admin/template', $data);
    }

    public function mypurchases()
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $customer_id = session('trav_id');
        $data['profile'] = $user_model->profile($id);

        $db = db_connect();
        $query = $db->query('select package.name as package, partnership.* from partnership, package where partnership.user_id = "'.$id.'" and package.id = partnership.package_id;');
        $row = $query->getRowArray();
        $data["partnership"] = $row;

        $data['main_content'] = 'admin/mypurchases';
        return view('includes/admin/template', $data);
    }

    public function refer_and_earn($cust_id)
    {
        $user_model = model('UserModel');
        $id = session('cust_id');
        $data['profile'] = $user_model->profile($id);
        $data['cust_id'] = $cust_id;
        $data['main_content'] = 'admin/refer_and_earn';
        return view('includes/admin/template', $data);
    }
}
