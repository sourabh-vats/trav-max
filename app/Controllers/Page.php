<?php

namespace App\Controllers;

class Page extends BaseController
{
	public function index()
	{
		echo 'hi';
	}

	public function services()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'services';
		$data['page_title'] = 'Services';

		$data['main_content'] = 'services';
		return view('includes/front/front_template', $data);
	}

	public function packages()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'packages';
		$data['page_title'] = 'packages';

		$data['main_content'] = 'packages';
		return view('includes/front/front_template', $data);
	}

	public function regis()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'regis';
		$data['page_title'] = 'regis';

		$data['main_content'] = 'regis';
		return view('includes/front/front_template', $data);
	}

	public function about()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'about';
		$data['page_title'] = 'about';

		$data['main_content'] = 'about';
		return view('includes/front/front_template', $data);
	}

	public function testimonials()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'testimonials';
		$data['page_title'] = 'testimonials';

		$data['main_content'] = 'testimonials';
		return view('includes/front/front_template', $data);
	}

	public function partner()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'partner';
		$data['page_title'] = 'partner';

		$data['main_content'] = 'partner';
		return view('includes/front/front_template', $data);
	}

	public function terms_of_use()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'terms_of_use';
		$data['page_title'] = 'terms_of_use';

		$data['main_content'] = 'terms_of_use';
		return view('includes/front/front_template', $data);
	}

	public function contact_us()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'contact_us';
		$data['page_title'] = 'contact_us';

		$data['main_content'] = 'contact_us';
		return view('includes/front/front_template', $data);
	}

	public function signup()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'signup';
		$data['page_title'] = 'signup';

		$data['main_content'] = 'signup';
		return view('signup', $data);
	}

	public function select_package()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'select_package';
		$data['page_title'] = 'select_package';

		$session = session();
		if (!$session->has('is_customer_logged_in')) {
			return redirect()->route('signup');
		}

		$trav_id = $session->get('trav_id');
		$id = $session->cust_id;
		$user_model = model('UserModel');
		$data['profile'] = $user_model->profile($id);

		// if ($data['profile'][0]['status'] == "hold" || $data['profile'][0]['status'] == 'active') {
		// 	return redirect()->route('admin');
		// } elseif ($data['profile'][0]['status'] == "process") {
		// 	# code...
		// } else {
		// 	return redirect()->route('/');
		// }

		$user_model = model('UserModel');
		$data['international'] = $user_model->get_international_packages();
		$data['national'] = $user_model->get_national_packages();

		$data['main_content'] = 'select_package';
		return view('select_package', $data);
	}

	public function choose_partnership()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'choose_partnership';
		$data['page_title'] = 'choose_partnership';

		$data['main_content'] = 'choose_partnership';
		return view('choose_partnership', $data);
	}

	public function choose_payment_plan()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'choose_payment_plan';
		$data['page_title'] = 'choose_payment_plan';

		$user_model = model('UserModel');
		$data['package_data'] = $user_model->get_package_data($_GET["package"]);
		$partner_type = $_GET["plan"];
		$number_of_packages = 1;
		if ($partner_type != "macro") {
			switch ($partner_type) {
				case 'microx':
					$number_of_packages = 1;
					break;
				case 'micro2x':
					$number_of_packages = 2;
					break;
				case 'micro3x':
					$number_of_packages = 3;
					break;
				case 'micro4x':
					$number_of_packages = 4;
					break;

				default:
					$number_of_packages = 1;
					break;
			}
		} else {
			$number_of_packages = 5;
		}
		$data['booking_packages_number'] = $number_of_packages;

		$data['main_content'] = 'choose_payment_plan';
		return view('choose_payment_plan', $data);
	}

	public function confirm_plan()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'confirm_plan';
		$data['page_title'] = 'confirm_plan';
		$data['css'] = '/css/confirm_plan.css';
		$data['js'] = '/js/confirm_plan.js';

		$user_model = model('UserModel');
		$session = session();
		$db = db_connect();

		$id = session('cust_id');
		$customer_id = session('trav_id');

		echo $session->get('trav_id');
		var_dump($session->get('trav_id'));
		echo $session->cust_id;
		echo $customer_id;
		echo $id;
		echo "test id";
		die();

		$data['profile'] = $user_model->profile($id);

		$package_id = $this->request->getGet('package');
		$payment_plan = $this->request->getGet('payment_plan');
		$payment_amount = 0;
		$data['package_data'] = $user_model->get_package_data($package_id);

		if (isset($_GET["plan"])) {
			$partner_type = $_GET["plan"];
		} else {
			$partner_type = $_POST["plan"];
		}

		$number_of_packages = 1;
		if ($partner_type != "macro") {
			switch ($partner_type) {
				case 'microx':
					$number_of_packages = 1;
					break;
				case 'micro2x':
					$number_of_packages = 2;
					break;
				case 'micro3x':
					$number_of_packages = 3;
					break;
				case 'micro4x':
					$number_of_packages = 4;
					break;

				default:
					$number_of_packages = 1;
					break;
			}
		} else {
			$number_of_packages = 5;
		}

		if ($payment_plan == 'traveasy_plan') {
			$payment_amount = 5500 * $number_of_packages;
		} elseif ($payment_plan == 'travlater_plan') {
			$payment_amount = 11000 * $number_of_packages;
		} elseif ($payment_plan == 'travnow_plan') {
			$payment_amount = $data['package_data'][0]['total'] * $number_of_packages;
		}
		$data['payment_amount'] = $payment_amount;

		if ($this->request->getMethod() === 'post') {
			$package_id = $this->request->getPost('package_id');
			$plan = $this->request->getPost('plan');
			$payment_type = $this->request->getPost('payment_plan');
			$package_data = $user_model->get_package_data($package_id);
			$package = $package_data[0];
			$package_amount_with_tax = $package["total"];
			//Add packages to user in purchase table
			for ($i = 1; $i <= $number_of_packages; $i++) {
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
					$installment_amount = 5500;
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
					$intallment_amount_left -= 5500;
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
						'status' => 'Active',
						'order_id' => $purchase_id
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

			$data_to_store = [
				'user_id' => $id,
				'package_id' => $package_id,
				'payment_type' => $payment_type,
				'amount_remaining' => $package_amount_with_tax
			];
			$return = $user_model->add_user_package($data_to_store);
			$data_to_store = [
				'role' => $partner_type,
				'status' => 'hold',
				'booking_packages_number' => $number_of_packages

				
			];
			$return = $user_model->update_profile($id, $data_to_store);
			if ($return == true) {
				$session->set('signup_email', 'true');
				return redirect()->to(base_url('admin/package_selected_successfully'));
			} else {
				$session->setFlashdata('flash_message', 'not_updated');
			}
		}
		$data['main_content'] = 'confirm_plan';
		return view('confirm_plan', $data);
	}

	public function micro_plans()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'micro_plans';
		$data['page_title'] = 'micro_plans';

		$data['main_content'] = 'micro_plans';
		return view('includes/front/front_template', $data);
	}

	public function mega()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'mega';
		$data['page_title'] = 'mega';

		$data['main_content'] = 'mega';
		return view('includes/front/front_template', $data);
	}

	public function feedback()
	{
		$customer_model = model('CustomerModel');
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'feedback';
		$data['page_title'] = 'feedback';
		$data['category_list'] = $customer_model->get_category_list();
		$data['feedback'] = '';

		if ($this->request->getMethod() === 'post' && $this->request->getPost('contact') === 'Submit') {
			$to = 'realwaterservices@gmail.com';
			$subject = $this->request->getPost('subject');
			$txt = 'email :- ' . $this->request->getPost('email') . '<br/>site speed :- ' . $this->request->getPost('speed') . '<br/>feedback :- ' . $this->request->getPost('message');
			$headers = 'From: feedback@realwaterservicese.com' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
			$headers .= 'From: <realwaterservices.com>' . "\r\n";
			// mail($to, $subject, $txt, $headers);
			$data['feedback'] = 'mail sent successfully';
		}

		$data['main_content'] = 'feedback';
		return view('includes/front/front_template', $data);
	}

	public function invite_friend($cust_id)
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'invite_friend';
		$data['page_title'] = 'invite_friend';
		$data['cust_id'] = $cust_id;
		$data['main_content'] = 'invite_friend';
		return view('includes/front/front_template', $data);
	}

	public function test_mail()
	{
		$data['page_keywords'] = '';
		$data['page_description'] = '';
		$data['page_slug'] = 'test_mail';
		$data['page_title'] = 'test_mail';

		$data['main_content'] = 'test_mail';
		return view('includes/front/front_template', $data);
	}
}
