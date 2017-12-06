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

if( ! function_exists('canTakeExam') )
{
	function canTakeExam($schedule_id = 0, $user_id = 0, $data_time = '0000-00-00')
	{
		$CI =& get_instance();
		if($schedule_data = $CI->common->scheduleAvailToTake($schedule_id, $data_time)) {
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
			$unseri_data = unserialize($schedule_candidates->candidates);
			if(is_array($unseri_data) && count($unseri_data) > 0 && in_array_r($user_id, $unseri_data)) {
				return true;
			}
		}
		return false;
	}
}



//Collect Question Ids from Exam Question table
if( ! function_exists('getExamQuestions') )
{
	function getExamQuestions($exam_id = 0)
	{
		$CI =& get_instance();
		if( $base_data = $CI->common->getExamQuestions($exam_id) ) {

			$seri_questions = $base_data->questions;
			unset($base_data->questions);

			$question_data = unserialize($seri_questions);

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





if( ! function_exists('getCandidateQuestionData') )
{
	function getCandidateQuestionData($schedule_id, $candidate_id, $questions)
	{
		$CI =& get_instance();
		$questions = implode(",", array_keys($questions));

		var_dump($questions);
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