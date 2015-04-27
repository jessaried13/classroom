<?php
class Reservations_model extends Model{


	var $table_headings = '';
	var $table_rows = array();


	function Reservations_model(){
		parent::Model();
		$this->CI =& get_instance();
  }





  function GetByDate($school_id = NULL, $date = NULL){
  	if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
  	if($date == NULL){ $date = date("Y-m-d"); }
  	$day_num = date('w', strtotime($date));
  	$query_str = "SELECT * FROM reservations WHERE school_id='$school_id' AND (date='$date' OR day_num=$day_num)";
  	#echo $query_str;
  	$query = $this->db->query($query_str);
  	$result = $query->result_array();
  	#print_r($result);
  	return $result;
  }
  
  function GetItemName(){
	
	$this->db->select('item_types.name AS item_type_name, item_groups.*');
	$this->db->from('item_groups');
	$this->db->join('item_types', 'item_groups.item_type_id=item_types.item_type_id', 'left');
	
	$query = $this->db->get();
	
	if( $query->num_rows() > 0 ){
		return $query->result();
	} else {
		return false;
	}
	
	  
  }
	
	
	function GetItemGroupNameSpecific($id = NULL){
	
	$this->db->select('item_groups.name AS item_group_name, items.*');
	$this->db->from('items');
	$this->db->join('item_groups', 'items.item_group_id=item_groups.item_group_id', 'left');
	$this->db->where('item_groups.item_group_id', $id);
	
	$query = $this->db->get();
	
	if( $query->num_rows() > 0 ){
		return $query->row();
	} else {
		return false;
	}
	
	  
  }


  /**
	 * Retrieve all bookings
	 * 
	 * @return				array				All bookings in table
	 */	 	 	 	
	function Get($reservation_id = NULL, $school_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
		
		// All "active" bookings (today onwards)
		$query_str = "SELECT * FROM reservations WHERE school_id='$school_id' AND status=0 ORDER BY date ASC";
		$query = $this->db->query($query_str);
		
		if( $query->num_rows() > 0 ){
			return $query->result();
		} else {
			return false;
		}
	}
	
		function GetNotification($user_id = NULL) {
	
		// All "active" bookings (today onwards)
		$query_str = "SELECT * FROM reservations WHERE user_id='$user_id' ORDER BY date ASC";
		$query = $this->db->query($query_str);
		
		if( $query->num_rows() > 0 ){
			return $query->result();
		} else {
			return false;
		}
		
	}
	
	function GetHistory($item_id = NULL) {
	
		$query_str = "SELECT * FROM reservations "
					."WHERE item_id=$item_id AND status=1";
					
		$query = $this->db->query($query_str);
		if($query->num_rows() >= 1){
			return $query->result();
		} else {
			return false;
		}
		
	}
	
	function GetAll() {
	
		$query_str = "SELECT * FROM reservations "
					."WHERE status=1";
					
		$query = $this->db->query($query_str);
		if($query->num_rows() >= 1){
			return $query->result();
		} else {
			return false;
		}
		
	}
	
	function GetFilter() {
	
		$query_str = "SELECT * FROM reservations "
					."WHERE status=1 AND action=0";
					
		$query = $this->db->query($query_str);
		if($query->num_rows() >= 1){
			return $query->result();
		} else {
			return false;
		}
		
	}
	
	function GetType() {
	
		$query_str = "SELECT * FROM types";
					
		$query = $this->db->query($query_str);
		if($query->num_rows() >= 1){
			return $query->result();
		} else {
			return false;
		}
		
	}
	
	function GetPeriod() {
	
		$query_str = "SELECT * FROM periods";
					
		$query = $this->db->query($query_str);
		if($query->num_rows() >= 1){
			return $query->result();
		} else {
			return false;
		}
		
	}
	
	function GetHistoryCount($item_id = NULL) {
	
		$query_str = "SELECT * FROM reservations "
					."WHERE item_id=$item_id AND status=1";
					
		$query = $this->db->query($query_str);
		if($query->num_rows() >= 1){
			return $query->num_rows();
		} else {
			return false;
		}
		
	}


  function TableAddColumn($td){
  	$this->table_headings .= $td;
  }

  function TableAddRow($data){
  	$this->table_rows[] = $data;
  }

  function Table(){
  	$table = '<tr>' . $this->table_headings . '</tr>';
		/* foreach($this->table_rows as $row){
			$table .= '<tr>' . $row . '</tr>';
		} */
		return $table;
  }
  
    function acceptReservation($school_id, $reservation_id) {
	
	    $query_str = "UPDATE reservations "
								."SET status=1 WHERE reservation_id=$reservation_id";
								
		$query = $this->db->query($query_str);
		return $query;
	  
  }
  
  function updateAction($reservation_id) {
	
	    $query_str = "UPDATE reservations "
								."SET action=1 WHERE reservation_id=$reservation_id";
								
		$query = $this->db->query($query_str);
		return $query;
	  
  }





  function ReservationCell($data, $key, $items, $users, $item_id, $url){

		// Check if there is a reservation
  	if(isset($data[$key])){

			// There's a reservation for this ID, set var
  		$reservation = $data[$key];

  		if($reservation->date == NULL){
  			// If no date set, then it's a static/timetable/recurring reservation
  			$cell['class'] = 'static';
  			$cell['body']= '';
  		} else {
  			// Check if booking status is approved.
			if ($reservation->status == 0) {
			
				$cell['class'] = 'reserve';
  				$cell['body'] = '';
				
			} else {
			
				$cell['class'] = 'staff';
  				$cell['body'] = '';	
				
			}
  		}

  		// Username info
  		if(isset($users[$reservation->user_id])){
  			$username = $users[$reservation->user_id]->username;
				$displayname = trim($users[$reservation->user_id]->displayname);
				if(strlen($displayname) < 2){ $displayname = $username; }
				$cell['body'] .= '<strong>'.$displayname.'</strong>';
				$user = 1;
  		}

			// Any notes?
			if($reservation->notes){
				if(isset($user)){ $cell['body'] .= '<br />'; }
				$cell['body'] .= '<span title="'.$reservation->notes.'">'.character_limiter($reservation->notes, 15).'</span>';
			}

			// Edit if admin?
			/* if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){
				$edit_url = site_url('reservations/edit/'.$reservation->reservation_id);
				$cell['body'] .= '<br /><a href="'.$edit_url.'" title="Edit this reservation"><img src="webroot/images/ui/edit.png" width="16" height="16" alt="Edit" title="Edit this reservation" hspace="8" /></a>';
				$edit = 1;
			} */

			// Cancel if user is an Admin, Item owner, or Reservation owner
			$user_id = $this->session->userdata('user_id');
			if(
				($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)) OR
				($user_id == $reservation->user_id) OR
				( ($user_id == $items[$item_id]->user_id) && ($reservation->date != NULL) )
			){
				$cancel_msg = 'Are you sure you want to cancel this reservation?';
				if($user_id != $reservation->user_id){
					$cancel_msg = 'Are you sure you want to cancel this reservation?\n\n(**) Please take caution, it is not your own reservation!!';
				}
				$cancel_url = site_url('reservations/cancel/'.$reservation->reservation_id);
				if(!isset($edit)){ $cell['body'] .= '<br />'; }
				$cell['body'] .= '<a onclick="if(!confirm(\''.$cancel_msg.'\')){return false;}" href="'.$cancel_url.'" title="Cancel this reservation"><img src="webroot/images/ui/delete.gif" width="16" height="16" alt="Cancel" title="Cancel this reservation" hspace="8" /></a>';
			}

		} else {

			// No reservations
			$book_url = site_url('reservations/book/'.$url);
  		$cell['class'] = 'free';
		
		if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){
			
			$cell['body'] = '<a href="javascript:void(0)"><img src="webroot/images/ui/accept.gif" width="16" height="16" alt="Reserve" title="Reserve" hspace="4" align="absmiddle" />Reserve</a>';
			
		} else if($this->userauth->CheckAuthLevel(GUEST, $this->authlevel)){
			
			$cell['body'] = '<img src="webroot/images/ui/tick.gif" width="16" height="16" alt="Book" title="Book" hspace="4" align="absmiddle" />Free Session';
			
		} else {
			
			$cell['body'] = '<a href="'.$book_url.'"><img src="webroot/images/ui/accept.gif" width="16" height="16" alt="Reserve" title="Reserve" hspace="4" align="absmiddle" />Reserve</a>';
			
		}
		  		
			if(!$this->userauth->CheckAuthLevel(GUEST, $this->authlevel)){
				$cell['body'] .= '<input type="checkbox" name="recurring[]" value="'.$url.'" />';
			}


		}
  	#$cell['width'] =
		#return sprintf('<td class="%s" valign="middle" align="center">%s</td>', $cell['class'], $cell['body']);
		return $this->load->view('reservations/table/reservationcell', $cell, True);
  }





  function html($school_id = NULL, $display = NULL, $cols = NULL, $date = NULL, $item_id = NULL, $school, $uri = NULL, $ninja_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }

		// Format the date to Ymd
		if($date == NULL){
			$date = Now();
			$date_ymd = date("Y-m-d", $date);
		} else {
			$date_ymd = date("Y-m-d", $date);
		}

		// Today's weekday number
		$day_num = date('w', $date);
		$day_num = ($day_num == 0 ? 7 : $day_num);


		// Get info on the current week
  	$this_week = $this->WeekObj($date, $school_id);


		// Init HTML + Jscript variable
  	$html = '';
  	$jscript = '';


		// Put users into array with their ID as the key
  	foreach($school['users'] as $user){
  		$users[$user->user_id] = $user;
  	}


		// Get items
  	$items = $this->Items($school_id);
  	if($items == False){
  		$html .= $this->load->view('msgbox/error', 'There are no items available. Please contact your administrator.', True);
  		return $html;
  	}


		// Find out which columns to display and which view type we use
		$style = $this->ReservationStyle($school_id);
		if(!$style OR ($style['cols'] == NULL OR $style['display'] == NULL) ){
			$html = $this->load->view('msgbox/error', 'No reservation style has been configured. Please contact your administrator.', True);
			return $html;
		}
		$cols = $style['cols'];
		$display = $style['display'];


		// Select a default item if none given (first item)
		if($item_id == NULL){
			$item_c = current($items);
			$item_id = $item_c->item_id;
			unset($item_c);
		}


		// Load the appropriate select box depending on view style
		switch($display){
			case 'item':
				$html .= $this->load->view('reservations/select_item', array('items' => $items, 'item_id' => $item_id, 'chosen_date' => $date_ymd ), True);
			break;
			case 'day':
				$html .= $this->load->view('reservations/select_date', array('chosen_date' => $date, 'item_id' => $item_id, 'ninja_id' => $ninja_id), True);
			break;
			default:
				$html .= $this->load->view('msgbox/error', 'Application error: No display type set.', True);
				return $html;
			break;
		}
  	// Date/item selecter bar
  	#$selects['date'] = $this->load->view('reservations/select_date', array('chosen_date' => $date), True);
  	#$selects['item'] = $this->load->view('reservations/select_item', array('items' => $items), True);
		#$html .= $this->load->view('reservations/selects', $selects, True);


  	// Return error if nothing available
  	/*if(!$this_week){
  		$html = $this->load->view('msgbox/error', 'Could not get details of current week - probably no week configured for this date.', True);
  		#return $html;
  	}*/




		// Do we have any info on this week name?
		if($this_week){

			// Get dates for each weekday
			if($display == 'item'){
				$this_date = strtotime("-1 day", strtotime($this_week->date));
				foreach($school['days_list'] as $d_day_num => $d_day_name){
					$weekdates[$d_day_num] = date("Y-m-d", strtotime("+1 day", $this_date));
					$this_date = strtotime("+1 day", $this_date);
				}
			}

		  	$week_bar['style'] = sprintf('padding:3px;font-weight:bold;background:#%s;color:#%s', $this_week->bgcol, $this_week->fgcol);

		  	// Change the week bar depending on view type
		  	switch($display){
		  		case 'item':
		  			$week_bar['back_date'] = date("Y-m-d", strtotime("last Week", $date));
		  			$week_bar['back_text'] = '&lt;&lt; Previous week';
					$week_bar['back_link'] = sprintf('reservations/index/date/%s/item/%s/direction/back', $week_bar['back_date'], $item_id);
		  			$week_bar['next_date'] = date("Y-m-d", strtotime("next Week", $date));
		  			$week_bar['next_text'] = 'Next week &gt;&gt;';
		  			$week_bar['next_link'] = sprintf('reservations/index/date/%s/item/%s/direction/next', $week_bar['next_date'], $item_id);
		  			$week_bar['longdate'] = 'Week commencing '.date("l jS F Y", strtotime($this_week->date));
		  		break;
		  		case 'day':
		  			$week_bar['longdate'] = date("l jS F Y", $date);
		  			$week_bar['back_date'] = date("Y-m-d", strtotime("yesterday", $date));
		  			$week_bar['back_link'] = sprintf('reservations/index/date/%s/direction/back', $week_bar['back_date']);
		  			$week_bar['next_date'] = date("Y-m-d", strtotime("tomorrow", $date));
				  	$week_bar['next_link'] = sprintf('reservations/index/date/%s/direction/next', $week_bar['next_date']);
				  	if(date("Y-m-d") == date("Y-m-d", $date)){
							$week_bar['back_text'] = '&lt;&lt; Yesterday';
				  		$week_bar['next_text'] = 'Tomorrow &gt;&gt; ';
				  	} else {
				  		$week_bar['back_text'] = '&lt;&lt; Back';
				  		$week_bar['next_text'] = 'Next &gt;&gt; ';
				  	}
		  		break;
		  	}
			$week_bar['week_name'] = $this_week->name;
			$week_bar['ninja_id'] = $ninja_id;
			$html .= $this->CI->load->view('reservations/week_bar', $week_bar, True);
		} else {
			$html .= $this->load->view('msgbox/error', 'A configuration error prevented the timetable from loading: <strong>no week configured</strong>.<br /><br />Please contact your administrator.', True);
			#return $html;
			$err = true;
		}


		// See if our selected date is in a holiday
		$query_str = "SELECT * "
								."FROM holidays "
								."WHERE date_start <= '$date_ymd' "
								."AND date_end >= '$date_ymd' AND active=1 "
								."LIMIT 1";
		$query = $this->db->query($query_str);
		if($query->num_rows() == 1){
			// The date selected IS in a holiday - give them a nice message saying so.
			$holiday = $query->row();
			$msg = sprintf(
				'The date you selected is during a holiday priod (%s, %s - %s).',
				$holiday->name,
				date("d/m/Y", strtotime($holiday->date_start)),
				date("d/m/Y", strtotime($holiday->date_end))
			);
			$html .= $this->load->view('msgbox/warning', $msg, True);

			// Let them choose the date afterwards/before
			// If navigating a day at a time, then just go one day.
			// If navigating one item at a time, move by one week
			if ($display === 'day') {
				$next_date = date("Y-m-d", strtotime("+1 day", strtotime($holiday->date_end)));
				$prev_date = date("Y-m-d", strtotime("-1 day", strtotime($holiday->date_start)));
			} elseif ($display === 'item') {
				$next_date = date("Y-m-d", strtotime("+1 week", strtotime($holiday->date_end)));
				$prev_date = date("Y-m-d", strtotime("-1 week", strtotime($holiday->date_start)));
			}

			#return $html;
			$err = true;
		}


		// Get periods
  	$query_str = "SELECT * FROM periods WHERE school_id='$school_id' AND bookable=1 AND active=1 ORDER BY time_start asc";
  	$query = $this->db->query($query_str);
  	if($query->num_rows() > 0){
  		$result = $query->result();
  		foreach($result as $period){
				// Check which days this period is for
				if($style['display'] == 'day'){
  				$school['days_bitmask']->reverse_mask($period->days);
  				if($school['days_bitmask']->bit_isset($day_num)){
  					$periods[$period->period_id] = $period;
  				}
  			} else {
  				$periods[$period->period_id] = $period;
  			}
  			#$days[$day_num] = $school['days_list'][$day_num];
  			#$days_available[$day_num] = $school['days_list'][$day_num];
  		}
	 	} else {
  		$html .= $this->load->view('msgbox/error', 'There are no periods available. Please see your administrator.', True);
  		#return $html;
  		$err = true;
  	}


  	// If this array isn't set, we don't have any periods configured for *this day*
		// If there were no periods at all, user would have been told before reaching this stage.
  	if(!isset($periods)){
  		$html .= $this->load->view('msgbox/warning', 'There are no periods configured for this week day. Please choose another date.', True);
  		return $html;
  	}

  	if( isset($err) && $err == true){
  		return $html;
  	}


  	$count['periods'] = count($periods);
  	$count['items'] = count($items);
  	$count['days'] = count($school['days_list']);
		#$col_width = sprintf('%d%%', (round($period_count/10) * 100) / $period_count );
		$col_width = sprintf('%s%%', round(100/($count[$cols]+1)));


		// Open form
		$html .= '<form class="scrollStyle" name="reservations" method="POST" action="' . site_url('reservations/recurring') . '">';
		$html .= form_hidden('item_id', $item_id);


		// Here goes, start table
		$html .= '<table border="0" bordercolor="#ffffff" cellpadding="2" cellspacing="2" class="reservations" width="100%">';


		// COLUMNS !!
		$html .= '<tr><td>&nbsp;</td>';


		switch($cols){
			case 'periods':
				foreach($periods as $period){
					$period->width = $col_width;
  				$html .= $this->load->view('reservations/table/cols_periods', $period, True);
  			}
  		break;
  		case 'days':
  			foreach($school['days_list'] as $dayofweek){
  				$day['width'] = $col_width;
  				$day['name'] = $dayofweek;
  				$html .= $this->load->view('reservations/table/headings/days', $day, True);
  			}
  		break;
  		case 'items':
  			foreach($items as $item){
					// Item name etc
					if($item->photo != NULL){
						$itemtitle['photo_lg'] = 'webroot/images/itemphotos/640/'.$item->photo;
						$itemtitle['photo_sm'] = 'webroot/images/itemphotos/160/'.$item->photo;
						$itemtitle['event'] = 'onmouseover="doTooltip(event,'.$item->item_id.')" onmouseout="hideTip()"';
						$itemtitle['width'] = 760;
						$jscript .= "messages[$item->item_id] = new Array('{$itemtitle['photo_sm']}','{$item->location}');\n";
					} else {
						$itemtitle['width'] = 400;
						$itemtitle['event'] = '';
					}
					$item->itemtitle = $itemtitle;
					$item->width = $col_width;
					$item->school_id = $school_id;
					#$jscript .= "messages[$item->item_id] = new Array('{$itemtitle['photo_sm']}','{$item->location}');\n";
  				$html .= $this->load->view('reservations/table/cols_items', $item, True);
  			}
  		break;
  	}	// End switch for cols

		// End COLUMNS row
		#$html .= '</tr>';


		// Get reservations
		#$query_str = "SELECT * FROM reservations WHERE school_id='$school_id' AND ((date >='$date_ymd') OR date Is Null)";
		#$query = $this->db->query($query_str);
		#$results = $query->result_array();

		$reservations = array();

		// Here we go!
		switch($display){

			case 'item':

				// ONE ROOM AT A TIME - COLS ARE PERIODS OR DAY NAMES...

				switch($cols){

					case 'periods':

						/*
							   [P1] [P2] [P3] ...
							[M]
							[T]
						*/

						// Columns are periods, so each row is a day name

						foreach($school['days_list'] as $day_num => $day_name){


							// Get reservation
							// TODO: Need to get date("Y-m-d") of THIS weekday (Mon, Tue, Wed) for this week
							$reservations = array();
							$query_str = "SELECT * FROM reservations "
													."WHERE school_id='$school_id' "
													."AND item_id='$item_id' "
													."AND ((day_num=$day_num AND week_id=$this_week->week_id) OR date='$weekdates[$day_num]') ";
							$query = $this->db->query($query_str);
							$results = $query->result();
							if($query->num_rows() > 0){
								foreach($results as $row){
									#echo $row->reservation_id;
									$reservations[$row->period_id] = $row;
								}
							}
							$query->free_result();

							// Start row
							$html .= '<tr>';

							// First cell
							$day['width'] = $col_width;
  						$day['name'] = $day_name;
							$html .= $this->load->view('reservations/table/rowinfo/days', $day, True);

							//$reservation_date_ymd = strtotime('+' . ($day_num - 1) . ' days', strtotime($date_ymd));
							//$reservation_date_ymd = date('Y-m-d', $reservation_date_ymd);
							$reservation_date_ymd = $weekdates[$day_num];

							// Now all the other ones to fill in periods
							foreach($periods as $period){


								// URL
								$url = 'period/%s/item/%s/day/%s/week/%s/date/%s';
								$url = sprintf($url, $period->period_id, $item_id, $day_num, $this_week->week_id, $reservation_date_ymd);

								// Check bitmask to see if this period is bookable on this day
								$school['days_bitmask']->reverse_mask($period->days);
								if($school['days_bitmask']->bit_isset($day_num)){
									// Bookable
									$html .= $this->ReservationCell($reservations, $period->period_id, $items, $users, $item_id, $url);
								} else {
									// Period not bookable on this day, do not show or allow any reservations
									$html .= '<td align="center">&nbsp;</td>';
								}

							}		// Done looping periods (cols)

							// This day row is finished
							$html .= '</tr>';

						}


					break;		// End $display 'item' $cols 'periods'

					case 'days':

						/*
							    [M] [T] [W] ...
							[P1]
							[P2]
						*/

						// Columns are days, so each row is a period

						foreach($periods as $period){

							// Get reservation
							// TODO: Need to get date("Y-m-d") of THIS weekday (Mon, Tue, Wed) for this week
							$reservations = array();
							$query_str = "SELECT * FROM reservations "
													."WHERE school_id='$school_id' "
													."AND item_id='$item_id' "
													."AND period_id='$period->period_id' "
													."AND ( (week_id=$this_week->week_id) OR (date >= '$weekdates[1]' AND date <= '$weekdates[7]' ) )";
													#."AND ((day_num=$day_num AND week_id=$this_week->week_id) OR date='$date_ymd') ";
							$query = $this->db->query($query_str);
							$results = $query->result();
							if($query->num_rows() > 0){
								foreach($results as $row){
									#echo $row->reservation_id;
									if($row->date != NULL){
										$this_daynum = date('w', strtotime($row->date) );
										$reservations[$this_daynum] = $row;
									} else {
										$reservations[$row->day_num] = $row;
									}
								}
							}
							$query->free_result();


							// Start row
							$html .= '<tr class='.$item->item_id.'>';

							// First cell, info
							$period->width = $col_width;
  						$html .= $this->load->view('reservations/table/rowinfo/periods', $period, True);

							//$reservation_date_ymd = strtotime('+' . ($day_num - 1) . ' days', strtotime($date_ymd));
							//$reservation_date_ymd = date('Y-m-d', $reservation_date_ymd);


							foreach($school['days_list'] as $day_num => $day_name){

								$reservation_date_ymd = $weekdates[$day_num];

								#$html .= '<td align="center" valign="middle">BOOK</td>';

								$url = 'period/%s/item/%s/day/%s/week/%s/date/%s';
								$url = sprintf($url, $period->period_id, $item_id, $day_num, $this_week->week_id, $reservation_date_ymd);


								// Check bitmask to see if this period is bookable on this day
								$school['days_bitmask']->reverse_mask($period->days);
								if($school['days_bitmask']->bit_isset($day_num)){
									// Bookable
									$html .= $this->ReservationCell($reservations, $day_num, $items, $users, $item_id, $url);
								} else {
									// Period not bookable on this day, do not show or allow any reservations
									$html .= '<td align="center">&nbsp;</td>';
								}

							}

							// This period row is finished
							$html .= '</tr>';

						}

					break;		// End $display 'item' $cols 'days'

			}

			break;
			case 'day':

				// ONE DAY AT A TIME - COLS ARE DAY NAMES OR ROOMS

				switch($cols){

					case 'periods':

						/*
							    [P1] [P2] [P3] ...
							[R1]
							[R2]
						*/

						// Columns are periods, so each row is a item

						foreach($items as $item){

							$reservations = array();
							// See if there are any reservations for any period this item.
							// A reservation will either have a date (teacher reservation), or a day_num and week_id (static/timetabled)
							$query_str = "SELECT * FROM reservations "
													."WHERE school_id='$school_id' "
													."AND item_id='$item->item_id' "
													."AND ((day_num=$day_num AND week_id=$this_week->week_id) OR date='$date_ymd') ";
							$query = $this->db->query($query_str);
							$results = $query->result();
							if($query->num_rows() > 0){
								foreach($results as $row){
									#echo $row->reservation_id;
									$reservations[$row->period_id] = $row;
								}
							}
							$query->free_result();		
							
							$item_group = array();
							// All "active" bookings (today onwards)
							$query_str = "SELECT * FROM item_groups WHERE 1";
							$query = $this->db->query($query_str);
							
							if( $query->num_rows() > 0 ){
								$item_group = $query->result();
							}				
							
							// Start row
							if ($item->item_group_id == $ninja_id) {
								
								$html .= '<tr class='.$item->item_group_id.'>';
								
								$itemtitle = array();
							if($item->photo != NULL){
								$itemtitle['photo_lg'] = 'webroot/images/itemphotos/640/'.$item->photo;
								$itemtitle['photo_sm'] = 'webroot/images/itemphotos/160/'.$item->photo;
								$itemtitle['event'] = 'onmouseover="doTooltip(event,'.$item->item_id.')" onmouseout="hideTip()"';
								$itemtitle['width'] = 760;
								$jscript .= "messages[".$item->item_id."] = new Array('".$itemtitle['photo_sm']."','".$item->location."');\n";
							} else {
								$itemtitle['width'] = 400;
								$itemtitle['event'] = '';
							}
							$item->itemtitle = $itemtitle;
							$item->width = $col_width;
							$item->school_id = $school_id;
							$item->ninja_id = $ninja_id;
							$item->item_group_name = $this->GetItemGroupNameSpecific($ninja_id)->item_group_name;
		  				$html .= $this->load->view('reservations/table/rowinfo/items', $item, True);

		  				foreach($periods as $period){
		  					$url = 'period/%s/item/%s/day/%s/week/%s/date/%s';
								$url = sprintf($url, $period->period_id, $item->item_id, $day_num, $this_week->week_id, $date_ymd);

								// Check bitmask to see if this period is bookable on this day
								$school['days_bitmask']->reverse_mask($period->days);
								if($school['days_bitmask']->bit_isset($day_num)){
									// Bookable
									$html .= $this->ReservationCell($reservations, $period->period_id, $items, $users, $item->item_id, $url);
								} else {
									// Period not bookable on this day, do not show or allow any reservations
									$html .= '<td align="center">&nbsp;</td>';
								}
		  					}

							// End row
							$html .= '</tr>';
								
							}
							
								

							

						}

					break;		// End $display 'day' $cols 'periods'

					case 'items':

							/*
							    [R1] [R2] [R3] ...
							[P1]
							[P2]
						*/

						// Columns are items, so each row is a period

						foreach($periods as $period){

							$reservations = array();
							// See if there are any reservations for any period this item.
							// A reservation will either have a date (teacher reservation), or a day_num and week_id (static/timetabled)
							$query_str = "SELECT * FROM reservations "
													."WHERE school_id='$school_id' "
													."AND period_id='$period->period_id' "
													."AND ((day_num=$day_num AND week_id=$this_week->week_id) OR date='$date_ymd') ";
							$query = $this->db->query($query_str);
							$results = $query->result();
							if($query->num_rows() > 0){
								foreach($results as $row){
									#echo $row->reservation_id;
									$reservations[$row->item_id] = $row;
								}
							}
							$query->free_result();

							// Start period row
							$html .= '<tr>';

							// First cell, info
							$period->width = $col_width;
  						$html .= $this->load->view('reservations/table/rowinfo/periods', $period, True);

  						foreach($items as $item){
		  					$url = 'period/%s/item/%s/day/%s/week/%s/date/%s';
								$url = sprintf($url, $period->period_id, $item->item_id, $day_num, $this_week->week_id, $date_ymd);

								// Check bitmask to see if this period is bookable on this day
								$school['days_bitmask']->reverse_mask($period->days);
								if($school['days_bitmask']->bit_isset($day_num)){
									// Bookable
									$html .= $this->ReservationCell($reservations, $item->item_id, $items, $users, $item->item_id, $url);
								} else {
									// Period not bookable on this day, do not show or allow any reservations
									$html .= '<td align="center">&nbsp;</td>';
								}
  						}

							// End period row
							$html .= '</tr>';

						}

					break;		// End $display 'day' $cols 'items'

				}

			break;

		}


		$html .= $this->Table();


		// Finish table
		$html .= '</table>';

		// Do javascript for hover DIVs for item information
		if($jscript != ''){ $html .= '<script type="text/javascript">'.$jscript.'</script>'; }


		// Show link to making a reservation for admins
		if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)){
			$html .= $this->load->view('reservations/make_recurring', array('users' => $school['users']), True);
		} else if($this->userauth->CheckAuthLevel(GUEST, $this->authlevel)) {
                    
                    /* do nothing */
                    
                } else {
                    
                    $html .= $this->load->view('reservations/make_recurring_date', array('users' => $school['users']), True);
                    
                }


		// Finaly return the HTML variable so the controller can then pass it to the view.
		return $html;
  }





  function Cancel($school_id = NULL, $reservation_id){
  	if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
  	$query_str = "DELETE FROM reservations "
								."WHERE school_id=$school_id AND reservation_id=$reservation_id LIMIT 1";
		/* $query_str = "UPDATE reservations SET cancelled=1 "
								."WHERE school_id=$school_id AND reservation_id=$reservation_id LIMIT 1"; */
		$query = $this->db->query($query_str);
		return $query;
  }





  function ReservationStyle($school_id){
  	$query_str = "SELECT d_columns,displaytype FROM school WHERE school_id='$school_id' LIMIT 1";
  	$query = $this->db->query($query_str);
  	if($query->num_rows() == 1){
  		$row = $query->row();
  		$style['cols'] = $row->d_columns;
  		$style['display'] = $row->displaytype;
  		return $style;
  	} else {
  		$style = false;
  	}
  }





  function Items($school_id){
  	$query_str = "SELECT items.*, users.user_id, users.username, users.displayname "
								."FROM items "
								."LEFT JOIN users ON users.user_id=items.user_id "
								."WHERE items.school_id='$school_id' AND items.bookable=1 "
								."ORDER BY name asc";
  	$query = $this->db->query($query_str);
  	if($query->num_rows() > 0){
  		$result = $query->result();
  		// Put all item data into an array where the key is the item_id
  		foreach($result as $item){
  			$items[$item->item_id] = $item;
  		}
  		return $items;
  	} else {
  		#$html .= $this->load->view('msgbox/error', 'There are no items available. Please see your administrator.', True);
  		#return $html;
  		return false;
  	}
  }





	/**
	 * Returns an object containing the week information for a given date
	 */
  function WeekObj($date, $school_id = NULL){
  	if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }
  	// First find the monday date of the week that $date is in
		if(date("w", $date) == 1){
			$nextdate = date("Y-m-d", $date);
		} else {
			$nextdate = date("Y-m-d", strtotime("last Monday", $date));
		}
		// Get week info that this date falls into
		$query_str = "SELECT * FROM weeks,weekdates "
								."WHERE weeks.week_id=weekdates.week_id "
								."AND weekdates.date='$nextdate' "
								."AND weeks.school_id='$school_id' "
								."LIMIT 1";
		$query = $this->db->query($query_str);
		if($query->num_rows() == 1){
			$row = $query->row();
		} else {
			$row = false;
		}
		return $row;
  }





  function Add($data){
		// Run query to insert blank row
		$this->db->insert('reservations', array('reservation_id' => NULL) );
		// Get id of inserted record
		$reservation_id = $this->db->insert_id();
		// Now call the edit function to update the actual data for this new row now we have the ID
		return $this->Edit($reservation_id, $data);
	}





	function Edit($reservation_id, $data){
		$this->db->where('reservation_id', $reservation_id);
		$this->db->set('school_id', $data['school_id']);
		$result = $this->db->update('reservations', $data);
		// Return bool on success
		if( $result ){
			return $reservation_id;
		} else {
			return false;
		}
	}





	function ByItemOwner($user_id){
		$maxdate = date("Y-m-d", strtotime("+14 days", Now()));
		$today = date("Y-m-d");
		$query_str = "SELECT items.*, reservations.*, users.username, users.displayname, users.user_id, periods.name as periodname "
								."FROM reservations "
								."JOIN items ON items.item_id=reservations.item_id "
								."JOIN users ON users.user_id=reservations.user_id "
								."JOIN periods ON periods.period_id=reservations.period_id "
								."WHERE items.user_id='$user_id' AND reservations.cancelled=0 "
								."AND reservations.date Is Not NULL "
								."AND reservations.date <= '$maxdate' "
								."AND reservations.date >= '$today' "
								."ORDER BY reservations.date, items.name ";
		$query = $this->db->query($query_str);
		if($query->num_rows() > 0){
			// We have some reservations
			return $query->result();
		} else {
			return false;
		}
	}





	function ByUser($user_id){
		$maxdate = date("Y-m-d", strtotime("+14 days", Now()));
		$today = date("Y-m-d");
		// All current reservations for this user between today and 2 weeks' time
		$query_str = "SELECT items.*, reservations.*, periods.name as periodname, periods.time_start, periods.time_end "
								."FROM reservations "
								."JOIN items ON items.item_id=reservations.item_id "
								."JOIN periods ON periods.period_id=reservations.period_id "
								."WHERE reservations.user_id='$user_id' AND reservations.cancelled=0 "
								."AND reservations.date Is Not NULL "
								."AND reservations.date <= '$maxdate' "
								."AND reservations.date >= '$today' "
								."ORDER BY reservations.date asc, periods.time_start asc";
		$query = $this->db->query($query_str);
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}





	function TotalNum($user_id, $school_id = NULL){
		if($school_id == NULL){ $school_id = $this->session->userdata('school_id'); }

		$today = date("Y-m-d");

		// All reservations by user, EVER!
		$query_str = "SELECT * FROM reservations WHERE user_id='$user_id'";
		$query = $this->db->query($query_str);
		$total['all'] = $query->num_rows();

		// All reservations by user, for this academic year, up to and including today
		$query_str = "SELECT * FROM reservations "
								."JOIN academicyears ON reservations.date >= academicyears.date_start "
								."WHERE user_id='$user_id' "
								."AND academicyears.school_id='$school_id' ";
		$query = $this->db->query($query_str);
		$total['yeartodate'] = $query->num_rows();

		// All reservations up to and including today
		$query_str = "SELECT * FROM reservations WHERE user_id='$user_id' AND date <= '$today'";
		$query = $this->db->query($query_str);
		$total['todate'] = $query->num_rows();

		// All "active" reservations (today onwards)
		$query_str = "SELECT * FROM reservations WHERE user_id='$user_id' AND date >= '$today'";
		$query = $this->db->query($query_str);
		$total['active'] = $query->num_rows();

		return $total;
	}





}
?>
