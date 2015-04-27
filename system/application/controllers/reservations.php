<?php
class Reservations extends Controller {





  function Reservations(){
    parent::Controller();

    // Load language
  	$this->lang->load('crbs', 'english');

		// Set school ID
		$this->school_id = $this->session->userdata('school_id');

		$this->output->enable_profiler(false);

    // Check user is logged in
    if(!$this->userauth->loggedin()){
    	$this->session->set_flashdata('login', $this->load->view('msgbox/error', $this->lang->line('crbs_auth_mustbeloggedin'), True) );
			redirect('site/home', 'location');
		} else {
			$this->loggedin = True;
			$this->authlevel = $this->userauth->GetAuthLevel($this->session->userdata('user_id'));
		}

		#$this->load->library('parser');

		$this->load->script('bitmask');
		$this->load->model('crud_model', 'crud');

		$this->load->model('items_model', 'M_items');
		$this->load->model('periods_model', 'M_periods');
		$this->load->model('weeks_model', 'M_weeks');

		$this->load->model('users_model', 'M_users');

		#$this->load->model('holidays_model', 'M_holidays');
		$this->load->model('reservations_model', 'M_reservations');
		#$this->load->library('table');

		// Array containing all the data we need (everything but the kitchen sink)
  	#$school['items']					= $this->M_items->Get(NULL, $this->school_id);
  	#$school['periods']				= $this->M_periods->Get();
  	#$school['weeks']					= $this->M_weeks->Get();
		#$school['holidays']				= $this->M_holidays->Get();
  	#$school['mondays']				= $this->M_weeks->GetMondays(NULL, $school['holidays']);
  	#$school['weekdateids']		= $this->M_weeks->WeekDateIDs();

		$school['users']					= $this->M_users->Get();
		$school['days_list'] 			= $this->M_periods->days;
		$school['days_bitmask']		= $this->M_periods->days_bitmask;
  	$this->school = $school;
  }



function inventory() {
	
		// Get list of items from database
		$body['items'] = $this->M_items->Get(NULL, $this->school_id);	//$this->session->userdata('schoolcode'));
		$body['users'] = $this->M_users->Get(NULL, $this->school_id);
		$body['item_type'] = $this->M_items->GetItemType(NULL);
		$body['item_groups'] = $this->M_reservations->GetItemName();
		$body['photo'] = $this->M_items->GetPhoto();
		// Set main layout
		$layout['title'] = 'Equipments';
		$layout['showtitle'] = $layout['title'];
		$layout['body'] = $this->load->view('reservations/test_index', $body, True);
		$this->load->view('index_layout', $layout );
	
}

  function index($ninja_id = NULL){
	
  	$uri = $this->uri->uri_to_assoc(3);

  	$this->session->set_userdata('uri', $this->uri->uri_string());

		if( ! isset($uri['date']) ){
			$uri['date'] = date("Y-m-d");
			$day_num = date('w', strtotime($uri['date']));
		}


		$item_of_user = $this->M_items->GetByUser($this->school_id, $this->session->userdata('user_id'));

		if(isset($uri['item'])){
			$uri['item'] = $uri['item'];
		} else {
			if($item_of_user != False){
				$uri['item'] = $item_of_user->item_id;
			} else {
				$uri['item'] = false;
			}
		}
		
		if ($ninja_id == 'date') {
		
			$ninja_id = $this->uri->segment(6);
			
		}

		$body['html'] = $this->M_reservations->html(
			$this->school_id,
			NULL,
			NULL,
			strtotime($uri['date']),
			$uri['item'],
			$this->school,
			$uri,
			$ninja_id
		);

		$layout['title'] = 'Reservations';
		$layout['showtitle'] = 'Item Reservations';	
		$layout['body'] = $this->session->flashdata('saved');
		$layout['body'] .= $body['html'];
		$layout['ninja_id'] = $ninja_id;
		$this->load->view('index_layout', $layout);
		#print_r($_SESSION);
  }




  /**
   * This function takes the date that was POSTed and loads the view()
   */
  function load($ninja_id = NULL){

  	$style = $this->M_reservations->ReservationStyle($this->school_id);

  	#$chosen_date = $this->input->post('chosen_date');

		// Validation rules
		$vrules['chosen_date']		= 'max_length[10]|callback__is_valid_date';
		$vrules['item_id']				= 'numeric';
		$this->validation->set_rules($vrules);
		$vfields['chosen_date']		= 'Date';
		$vfields['item_id']				= 'Item';
		$vfields['direction']			= 'Direction';
		$this->validation->set_fields($vfields);

		// Set the error delims to a nice styled red hint under the fields
		$this->validation->set_error_delimiters('<p class="hint error"><span>', '</span></p>');

    if ($this->validation->run() == FALSE){

			show_error('validation failed');

    } else {

    	switch($style['display']){
    		case 'day':
    			// Display type is one day at a time - all items/periods
		    	if($this->input->post('chosen_date')){
						$datearr = explode('/', $this->input->post('chosen_date'));
						if(count($datearr) == 3){
							$chosen_date = sprintf("%s-%s-%s", $datearr[2], $datearr[0], $datearr[1]);
							$url = sprintf('reservations/index/date/%s/direction/%s', $chosen_date, $ninja_id);
							#$this->session->set_flashdata('uri', $url);
							redirect($url, 'redirect');
						} else {
							show_error('invalid date');
						}
					} else {
						show_error('no date chosen');
					}
				break;
				case 'item':
					if($this->input->post('item_id')){
						$url = sprintf(
							'reservations/index/date/%s/item/%s/directions/%s/%s',
							$this->input->post('chosen_date'),
							$this->input->post('item_id'),
							$this->input->post('direction')
						);
						#$this->session->set_flashdata('uri', $url);
						redirect($url, 'redirect');
					} else {
						show_error('no day selected');
					}
				break;
			} // End switch

    }
	}





	function book(){
		$uri = $this->uri->uri_to_assoc(3);
		#$this->session->set_userdata('uri', $uri);

		$layout['title'] = 'Reserve an item';
		$layout['showtitle'] = $layout['title'];

		$seg_count = $this->uri->total_segments();
		if($seg_count != 2 && $seg_count != 12){

			// Not all info in URI
			$layout['body'] = $this->load->view('msgbox/error', 'Not enough information specified to book a item.', True);

		} else {

			// Either no URI, or all URI info specified

			// 12 segments means we have all info - adding a reservation
			if($seg_count == 12){

				// Create array of data from the URI
				$reservation['reservation_id'] = 'X';
				$reservation['period_id'] = $uri['period'];
				$reservation['item_id'] = $uri['item'];
				$reservation['date']	= date("d/m/Y", strtotime($uri['date']));

				if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){
					$reservation['day_num'] = $uri['day'];
					$reservation['week_id']	= $uri['week'];
				} else {
					$reservation['user_id'] = $this->session->userdata('user_id');
				}

				$body['reservation'] = $reservation;
				$body['hidden'] = $reservation;


			} else {
				$body['hidden'] = array();
			}

			// Lookups we need if an admin user
			if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){
				$body['days'] = $this->M_periods->days;
				$body['items'] = $this->M_items->Get(NULL, $this->school_id);
				$body['periods'] = $this->M_periods->Get();
				$body['weeks'] = $this->M_weeks->Get();
				$body['users'] = $this->M_users->Get();
			}

			$layout['body'] = $this->load->view('reservations/reservations_book', $body, True);

			// Check that the date selected is not in the past
			$today = strtotime(date("Y-m-d"));
			$thedate = strtotime($uri['date']);

			if(!$this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){
				if($thedate < $today){
					$layout['body'] = $this->load->view('msgbox/error', 'You cannot make a reservation in the past.', True);
				}
			}

			// Now see if user is allowed to book in advance
			if(!$this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){

				$bia = (int) $this->_reservation_advance($this->school_id);
				if ($bia > 0) {
					$date_forward = strtotime("+$bia days", $today);
					if($thedate > $date_forward){
						$layout['body'] = $this->load->view('msgbox/error', 'You can only reserve '.$bia.' days in advance.', True);
					}

				}
			}

		}


		$this->load->view('index_layout', $layout);
		#print_r( $_SESSION );
	}





	function recurring(){
		foreach($this->input->post('recurring') as $reservation){
			$arr = explode('/', $reservation);
			$max = count($arr);
			#print_r($arr);
			$reservation = array();
			for($i=0;$i<count($arr);$i=$i+2){
				$reservation[$arr[$i]] = $arr[$i+1];
			}
			$reservations[] = $reservation;
		}
		$errcount = 0;
		#echo "<hr>";
		#echo "<pre>".var_export($reservations,true)."</pre>";
		foreach($reservations as $reservation){
			$data = array();
			$data['user_id'] = $this->session->userdata('user_id');
			$data['school_id'] = $this->school_id;
			$data['period_id'] = $reservation['period'];
			$data['item_id'] = $reservation['item'];
			$data['notes'] = $this->input->post('notes');
			$data['week_id'] = $reservation['week'];
			$data['day_num'] = $reservation['day'];
			if ($this->session->userdata('user_id') != 1) {
				$data['date'] = date("Y-n-d", strtotime($reservation['date']));
			}
			if(!$this->M_reservations->Add($data)){
				$errcount++;
			}
		}
		if($errcount > 0){
			$flashmsg = $this->load->view('msgbox/error', 'One or more reservations could not be made.', True);
		} else {
			$flashmsg = $this->load->view('msgbox/info', 'The reservations were created successfully.', True);
		}

		$this->session->set_userdata('notes', $data['notes']);

		// Go back to index
		$this->session->set_flashdata('saved', $flashmsg);

		$uri = $this->session->userdata('uri');
		#if($data['date']){ $url = 'reservations/index/'.$data['date']; } else { $url = 'reservations'; }
		$uri = ($uri) ? $uri : 'reservations';
		redirect($uri, 'location');
		#echo anchor($uri, 'Go');
	}





	function cancel(){
		$uri = $this->session->userdata('uri');
		$reservation_id = $this->uri->segment(3);
		if($this->M_reservations->Cancel($this->school_id, $reservation_id)){
			$msg = $this->load->view('msgbox/info', 'The reservation has been <strong>cancelled</strong>.', True);
		} else {
			$msg = $this->load->view('msgbox/error', 'An error occured cancelling the reservation.', True);
		}
		$this->session->set_flashdata('saved', $msg);
		if($uri == NULL){ $uri = 'reservations'; }
		redirect($uri, 'redirect');
	}
	
	function accept() {
			
		$uri = $this->session->userdata('uri');
		$reservation_id = $this->uri->segment(3);
		if($this->M_reservations->acceptReservation($this->school_id, $reservation_id)){
			$msg = $this->load->view('msgbox/info', 'The reservation has been <strong>accepted</strong>.', True);
		} else {
			$msg = $this->load->view('msgbox/error', 'An error occured accepting the reservation.', True);
		}
		$this->session->set_flashdata('saved', $msg);
		redirect('profile/admin_index');
		
		
	}
	
	function reject() {
	
		$uri = $this->session->userdata('uri');
		$reservation_id = $this->uri->segment(3);
		if($this->M_reservations->Cancel($this->school_id, $reservation_id)){
			$msg = $this->load->view('msgbox/info', 'The reservation has been <strong>rejected</strong>.', True);
		} else {
			$msg = $this->load->view('msgbox/error', 'An error occured rejecting the reservation.', True);
		}
		$this->session->set_flashdata('saved', $msg);
		redirect('profile/admin_index');
		
	}




	function edit(){
		$uri = $this->session->userdata('uri');
		$reservation_id = $this->uri->segment(3);

		$reservation = $this->M_reservations->Get();

		// Lookups we need if an admin user
		if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){
			$body['days'] = $this->M_periods->days;
			$body['items'] = $this->M_items->Get($this->school_id, NULL);
			$body['periods'] = $this->M_periods->Get();
			$body['weeks'] = $this->M_weeks->Get();
			$body['users'] = $this->M_users->Get();
		}

		$layout['body'] = $this->load->view('reservations/reservations_book', $body, True);

		// Check that the date selected is not in the past
		/*$today = strtotime(date("Y-m-d"));
		$thedate = strtotime($uri['date']);
		if($thedate < $today){
			$layout['body'] = $this->load->view('msgbox/error', 'You cannot make a reservation in the past.', True);
		}*/

		$this->load->view('index_layout', $layout);

	}





	function save(){

	 	// Get ID from form
		$reservation_id = $this->input->post('reservation_id');

		// Validation rules
		$vrules['reservation_id']		= 'required';
		$vrules['date']					= 'max_length[10]|callback__is_valid_date';
		$vrules['use']					= 'max_length[100]';
		$this->validation->set_rules($vrules);

		// Pretty it up a bit for error validation message
		$vfields['reservation_id']		= 'Reservation ID';
		$vfields['date']					= 'Date';
		$vfields['period_id']			= 'Period';
		$vfields['user_id']				= 'User';
		$vfields['item_id']				= 'Item';
		$vfields['week_id']				= 'Week';
		$vfields['day_num']				= 'Day of week';
		$this->validation->set_fields($vfields);

		// Set the error delims to a nice styled red hint under the fields
		$this->validation->set_error_delimiters('<p class="hint error"><span>', '</span></p>');

    if ($this->validation->run() == FALSE){

      // Validation failed
			if($reservation_id != "X"){
				return $this->Edit($reservation_id);
			} else {
				return $this->book();
			}

		} else {

			// Validation succeeded

			// Data that goes into database regardless of reservation type
			$data['user_id'] = $this->input->post('user_id');
			$data['school_id'] = $this->school_id;
			$data['period_id'] = $this->input->post('period_id');
			$data['item_id'] = $this->input->post('item_id');
			$data['notes'] = $this->input->post('notes');

			// Hmm.... now to see if it's a static reservation or recurring or whatever... :-)
			if($this->input->post('date')){
				// Once-only reservation

				$date_arr = explode('/', $this->input->post('date'));
				$data['date'] = date("Y-m-d", mktime(0,0,0,$date_arr[1], $date_arr[0], $date_arr[2] ) );
				$data['day_num'] = NULL;
				$data['week_id'] = NULL;
			}

			// If week_id and day_num are specified, its recurring
			if($this->input->post('recurring') && ($this->input->post('week_id') && $this->input->post('day_num'))){
				// Recurring
				$data['date'] = NULL;
				$data['day_num'] = $this->input->post('day_num');
				$data['week_id'] = $this->input->post('week_id');
			}


			#print '<pre>Going to database: '.var_export($data,true).'</pre>';


			// Now see if we are editing or adding
			if($reservation_id == 'X'){
				// No ID, adding new record
				#echo 'adding';
				if(!$this->M_reservations->Add($data)){
					$flashmsg = $this->load->view('msgbox/error', sprintf($this->lang->line('dberror'), 'adding', 'reservation'), True);
				} else {
					$flashmsg = $this->load->view('msgbox/info', 'The reservation has been made.', True);
				}
			} else {
				// We have an ID, updating existing record
				#echo 'editing';
				if(!$this->M_reservations->Edit($reservation_id, $data)){
					$flashmsg = $this->load->view('msgbox/error', sprintf($this->lang->line('dberror'), 'editing', 'reservation'), True);
				} else {
					$flashmsg = $this->load->view('msgbox/info', 'The reservation has been updated.', True);
				}
			} // End of reservation_id=X

			#echo $flashmsg;

			// Go back to index
			$this->session->set_flashdata('saved', $flashmsg);

			$uri = $this->session->userdata('uri');
			#if($data['date']){ $url = 'reservations/index/'.$data['date']; } else { $url = 'reservations'; }
			$uri = ($uri) ? $uri : 'reservations';
			redirect($uri, 'location');
			#echo anchor($uri, 'OK');

		}

	}




	function callback__is_valid_date($date){
		$datearr = split('/', $date);
		if(count($datearr) == 3){
			$valid = checkdate($datearr[1], $datarr[0], $datearr[2]);
			if($valid){
				$ret = true;
			} else {
				$ret = false;
				$this->validation->set_message('_is_valid_date', 'Invalid date');
			}
		} else {
			$ret = false;
			$this->validation->set_message('_is_valid_date', 'Invalid date');
		}
		return $ret;
	}



	// Get reservation in advance days
	function _reservation_advance($school_id){
		$query_str = "SELECT bia FROM school WHERE school_id='$school_id' LIMIT 1";
		$query = $this->db->query($query_str);
		if($query->num_rows() == 1){
			$row = $query->row();
			return $row->bia;
		} else {
			return 'X';
		}
	}







}
?>
