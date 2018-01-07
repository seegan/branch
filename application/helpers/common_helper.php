<?php  
defined('BASEPATH') or exit('No direct script access allowed');


    

if( ! function_exists('hasBranchAccess') )
{
	function hasBranchAccess($branch_id = 0, $user_id = 0)
	{
		$CI =& get_instance();
		if( $CI->auth_level == 1) {
			
			if( $candidate_data = $CI->common->hasBranchAccessCandidate($branch_id, $user_id) ) {
				return $candidate_data;
			}
		}
		redirect('candidate/auth/logout');
	}
}


if( ! function_exists('getScheduleDetail') )
{
	function getScheduleDetail($schedule_id = 0) {
		$CI =& get_instance();
		if($schedule_data = $CI->common->getScheduleData($schedule_id)) {
			return $schedule_data;
		}
		return false;
	}	
}


// End of Can Take Exam Check

if( ! function_exists('canTakeExam') )
{
	function canTakeExam($schedule_id = 0, $user_id = 0, $date_time = '0000-00-00')
	{
		$CI =& get_instance();
		if($schedule_data = $CI->common->scheduleAvailToTake($schedule_id, $date_time)) {
			if( scheduleAvailToCandidate($schedule_id, $user_id, $schedule_data->schedule_to) ) {
				return $schedule_data;
			}
		}
		return false;
	}
}


if( ! function_exists('scheduleAvailToCandidate') )
{
	function scheduleAvailToCandidate($schedule_id = 0, $user_id = 0, $schedule_to = 2)
	{
		$CI =& get_instance();
		if( $CI->common->scheduleAvailToCandidate($schedule_id, $user_id) ) {
			if($schedule_to != 1) {
				return checkScheduleAvailToSelectedCandidate($schedule_id, $user_id);
			}
			return true;
		}
		return false;
	}
}

if( ! function_exists('checkScheduleAvailToSelectedCandidate') )
{
	function checkScheduleAvailToSelectedCandidate($schedule_id = 0, $user_id = 0)
	{
		$CI =& get_instance();
		if( $schedule_candidates = $CI->common->getScheduleCandidateDetail($schedule_id) ) {
			$unseri_data = json_decode($schedule_candidates->candidates, true);
			if(is_array($unseri_data) && count($unseri_data) > 0 && in_array_r($user_id, $unseri_data)) {
				return true;
			}
		}
		return false;
	}
}
// End of Can Take Exam Check


// End of Can Submit Exam Check

if( ! function_exists('timeAvailToTakeExam') )
{
	function timeAvailToTakeExam($schedule_id = 0, $user_id = 0)
	{
		$CI =& get_instance();
		$current_time = date('Y-m-d H:i:s');

		$candidate_time_remain = $CI->common->scheduleTimeRemainToCandidate($schedule_id, $user_id);
		$exam_time_remain = $CI->common->scheduleTimeRemainToExam($schedule_id, $current_time);

		if( $candidate_time_remain && $exam_time_remain && !$CI->common->scheduleCandidateSubmitStatus($schedule_id, $user_id)) {
			if($exam_time_remain->time_remain >= $candidate_time_remain->time_remain) {
				return $candidate_time_remain;
			} else {
				if($exam_time_remain->time_remain < 0) {
					return false;
				} else {
					return $exam_time_remain;
				}
			}
		}
		return false;
	}
}

// End of Can Submit Exam Check


//Collect Question Ids from Exam Question table
if( ! function_exists('getExamQuestions') )
{
	function getExamQuestions($exam_id = 0)
	{
		$CI =& get_instance();
		if( $base_data = $CI->common->getExamQuestions($exam_id) ) {

			$seri_questions = $base_data->questions;
			unset($base_data->questions);

			$question_data = json_decode($seri_questions, true);

			$data['questions'] = implode(",", array_keys($question_data));
			$data['question_data'] = combainQuestionOptions($data['questions']);
			$data['exam_detail'] = $base_data;
			return $data;
		}
		return false;
	}
}



if( ! function_exists('combainQuestionOptions') )
{
	function combainQuestionOptions($question_ids)
	{
		$CI =& get_instance();
		$questions = $CI->common->getQuestions($question_ids);
		$options = $CI->common->getOptions($question_ids);

		$option_gruped = array();
		foreach ($options as $item) {
		  // copy item to grouped
		  $option_gruped[$item['question_id']][] = $item;
		}

		$question_gruped = array();
		foreach ($questions as $item) {
		  // copy item to grouped
			$item['options'] = $option_gruped[$item['question_id']];
		  	$question_gruped[$item['question_id']] = $item;
		}
		return $question_gruped;
	}
}



if( ! function_exists('combainQuestionAnswers') )
{
	function combainQuestionAnswers($question_ids)
	{
		$CI =& get_instance();
		$questions = $CI->common->getQuestions($question_ids, 'mark');
		$answers = $CI->common->getAnswers($question_ids);
		
		$answer_gruped = array();
		foreach ($answers as $item) {
		  // copy item to grouped
		  $answer_gruped[$item['question_id']] = $item;
		}
		$question_gruped = array();
		foreach ($questions as $item) {
		  //copy item to grouped
			$item['answer_option'] = $answer_gruped[$item['question_id']]['option_id'];
		  	$question_gruped[$item['question_id']] = $item;
		}
		return $question_gruped;
	}
}




if( ! function_exists('getCandidateQuestionData') )
{
	function getCandidateQuestionData($schedule_id, $candidate_id)
	{
		$CI =& get_instance();
		if( $data = $CI->common->getAttendedScheduleDetail($schedule_id, $candidate_id) ) {
			return json_decode( $data->answer_data, true );
		}
		return false;
	}
}

if( ! function_exists('getCandidatePreviousScheduledData') )
{
	function getCandidatePreviousScheduledData($schedule_id, $candidate_id, $scheduled_hash='')
	{
		$CI =& get_instance();
		if( $data = $CI->common->getAttendedScheduleDetail($schedule_id, $candidate_id, $scheduled_hash) ) {
			return $data;
		}
		return false;
	}
}

if( ! function_exists('getScheduleCandidateData') )
{
	function getScheduleCandidateData($schedule_id, $candidate_id)
	{
		$CI =& get_instance();
		if( $data = $CI->common->getAttendedScheduleDetail($schedule_id, $candidate_id) ) {
			return $data;
		}
		return false;
	}
}










if( ! function_exists('getBatchCurrentExams') )
{
	function getBatchCurrentExams($batch_id = 0, $date = '0000-00-00')
	{
		$CI =& get_instance();
		if( $current = $CI->common->getBatchCurrentExams($batch_id, $date) ) {
			return $current;
		}
		return false;
	}
}

if( ! function_exists('getBatchUpcommingExams') )
{
	function getBatchUpcommingExams($batch_id = 0)
	{
		$CI =& get_instance();
		if( $upcomming = $CI->common->getBatchUpcommingExams($batch_id) ) {
				return $upcomming;
		}
		return false;
	}
}



if( ! function_exists('canSchedulePublishResult') )
{
	function canSchedulePublishResult($schedule_id = 0, $result_date = '')
	{
		$CI =& get_instance();
		if( $canResult = $CI->common->canSchedulePublishResult($schedule_id, $result_date) ) {
			if($canResult && $canResult->result_avail == 1) {
				return true;
			}
		}
		return false;
	}
}





















if( ! function_exists('secondsToHuman') )
{
	function secondsToHuman($seconds) {
	  	$t = round($seconds);
	  	return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
	}
}








if( ! function_exists('getYearList') )
{
	function getYearList( $selected_year = '' )
	{
		$CI =& get_instance();
		$year_list = $CI->config->item('years');
		$current_year = date('Y');
		$year_end = ($current_year + 3);

		foreach ($year_list as $key => $year) {
			$years[$key]['year'] = $year;
			$years[$key]['selected'] = false;
			if($year == $selected_year) {
				$years[$key]['selected'] = true;
			}
			if($year == $year_end) {
				break;
			}
		}

		return $years;
	}
}


if( ! function_exists('getLanguageList') )
{
	function getLanguageList( $selected_language = '' )
	{
		$CI =& get_instance();
		$language_list = $CI->config->item('languages');

		foreach ($language_list as $key => $language) {
			$languages[$key]['language'] = $language;
			$languages[$key]['selected'] = false;
			if($key == $selected_language) {
				$languages[$key]['selected'] = true;
			}
		}

		return $languages;
	}
}

if( ! function_exists('getDifficultyList') )
{
	function getDifficultyList( $selected_diff = '' )
	{
		$CI =& get_instance();
		$difficulty_list = $CI->config->item('difficulty');

		foreach ($difficulty_list as $key => $difficulty) {
			$difficulties[$key]['difficulty'] = $difficulty;
			$difficulties[$key]['selected'] = false;
			if($key == $selected_diff) {
				$difficulties[$key]['selected'] = true;
			}
		}

		return $difficulties;
	}
}


if( ! function_exists('in_array_r') )
{
	function in_array_r($needle, $haystack, $strict = false) {
	    foreach ($haystack as $item) {
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
	            return true;
	        }
	    }
	    return false;
	}
}



if( ! function_exists('join_date_time') )
{
	function join_date_time($date = '12 Dec 2017', $time= '00:00 AM') {
		$date_time = $date.' '.$time;
		return $date_time;
	}
}

if( ! function_exists('man_to_machine_date') )
{
	function man_to_machine_date($date_time) {
		return date("Y-m-d H:i:s", strtotime($date_time));
	}
}



if( ! function_exists('setCandidateAttendSchedule') )
{
	function setCandidateAttendSchedule($schedule_id, $user_id, $date_time) {

		$CI =& get_instance();
		$hash = get_unused_exam_hash();
		$ans_data = json_encode(array());

		$schedule_data = array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash, 'last_update' => $date_time);

		$schedule_query = "SELECT cas.id FROM xtra_candidate_attended_schedule as cas WHERE cas.user_id = ${user_id} AND cas.schedule_id = ${schedule_id} AND cas.active = 1";
		$schedule_attempted = $CI->db->query($schedule_query);

		if( $data = $schedule_attempted->row() ) {
			$attend_schedule_id = $data->id;
			$CI->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id));
			$CI->db->update('xtra_candidate_attended_schedule', $schedule_data); 
		} else {
			$CI->db->set($schedule_data)->insert('xtra_candidate_attended_schedule');
			if( $CI->db->affected_rows() != 1 ){
				return false;
			}
			$attend_schedule_id = $CI->db->insert_id();
		}

		$attend_data = array('attend_schedule_id' => $attend_schedule_id,'user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash, 'taken_from' => $date_time, 'taken_to' => $date_time, 'answer_data' => $ans_data, 'schedule_status' => 'open');
		$CI->db->set($attend_data)->insert('xtra_candidate_attended_data');
		if( $CI->db->affected_rows() != 1 ){
			return false;
		}
		return $hash;
	}
}


if( ! function_exists('get_unused_exam_hash') )
{
	function get_unused_exam_hash() { 

		$CI =& get_instance();
	    $random_unique_int = 2147483648 + mt_rand( -2147482448, 2147483647 );
	    $hash_data = 'XTRA'.date("y").$random_unique_int;

		if( $CI->common->checkExamHash($hash_data) ) {
			return get_unused_exam_hash();
		}
		return $hash_data;
	}
}


if( ! function_exists('createCandidateImageDatabase') )
{
	function createCandidateImageDatabase($schedule_id = 0, $candidate_id = 0, $file_name = '', $hash_code = '') {
		$CI =& get_instance();
		$table = 'xtra_candidate_exam_images';

		$data = array('schedule_id' => $schedule_id,'candidate_id' => $candidate_id, 'hash_code' => $hash_code, 'file_name' => $file_name);
		return $CI->common->insert($table, $data);
	}
}

