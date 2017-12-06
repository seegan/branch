<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends MY_Model {

	/**
	 * Check the user table to see if a user exists by username or email address.
	 *
	 * While this query is rather limited, you could easily join with
	 * other custom tables, and return specific user profile data.
	 * 
	 * @param   string  either the username or email address of a user
	 * @return  mixed   either query data as object or FALSE
	 */
	public function hasBranchAccessCandidate( $branch, $user )
	{
		$query = $this->db->query("SELECT c.name, c.enrollment_no, b.name as branch_name, cbb.branch_id, cbb.batch_id FROM xtra_candidate_branch_batch as cbb JOIN xtra_candidate as c ON cbb.candidate_id = c.user_id JOIN xtra_branch as b ON cbb.branch_id = b.id WHERE b.active = 1 AND cbb.active = 1 AND c.active = 1 AND cbb.branch_id = ".$branch." AND cbb.candidate_id = ".$user);
		return $query->row();
	}

	public function getBatchUpcommingExams($batch_id = 0) {
		$query = $this->db->query("SELECT es.id as schedule_id, e.id as exam_id, es.schedule_name, es.description as schedule_description, es.start_date, es.end_date, es.result_date, es.offered_as, es.offer_cost, es.result_as, es.schedule_to, e.exam_duration, e.total_questions, e.total_marks, e.description as exam_description  FROM xtra_exam_schedule_batchs as esb JOIN xtra_exam_schedule as es ON esb.schedule_id = es.id JOIN xtra_exam as e ON es.exam_id = e.id WHERE es.active = 1 AND e.active = 1 AND esb.active = 1 AND esb.batch_id = ".$batch_id);
		return $query->result();
	}


	public function getBatchCurrentExams($batch_id = 0, $current_date = '000-00-00') {
		$query = $this->db->query("SELECT es.id as schedule_id, e.id as exam_id, es.schedule_name, es.description as schedule_description, es.start_date, es.end_date, es.result_date, es.offered_as, es.offer_cost, es.result_as, es.schedule_to, e.exam_duration, e.total_questions, e.total_marks, e.description as exam_description  FROM xtra_exam_schedule_batchs as esb JOIN xtra_exam_schedule as es ON esb.schedule_id = es.id JOIN xtra_exam as e ON es.exam_id = e.id WHERE es.active = 1 AND e.active = 1 AND esb.active = 1 AND esb.batch_id = '{$batch_id}' AND '${current_date}' between es.start_date AND es.end_date");
		return $query->result();
	}


	public function scheduleAvailToTake($schedule_id, $data_time = '0000-00-00') {
		$query = $this->db->query("select es.id as schedule_id, es.exam_id, es.schedule_name, es.description, es.start_date, es.end_date, es.result_date, es.offered_as, es.offer_cost, es.result_as, es.schedule_to, TIMESTAMPDIFF(SECOND, '${data_time}', es.end_date) as time_to_end from xtra_exam_schedule as es WHERE es.active = 1 AND es.id =${schedule_id} AND '${data_time}' between es.start_date AND es.end_date");
		return $query->row();
	}


	public function scheduleAvailToCandidate($schedule_id, $user_id) {
		$query = $this->db->query("SELECT cbb.batch_id FROM xtra_candidate_branch_batch as cbb JOIN xtra_exam_schedule_batchs as esb ON cbb.batch_id = esb.batch_id WHERE esb.active = 1 AND cbb.active = 1 AND esb.schedule_id = ${schedule_id} AND cbb.candidate_id = ${user_id}");
		return $query->row();
	}


	public function getScheduleCandidateDetail($schedule_id = 0) {
		$query = $this->db->query("SELECT candidates FROM xtra_exam_schedule_candidates as sc WHERE sc.schedule_id = ${schedule_id}");
		return $query->row();
	}

	public function getExamQuestions($exam_id = 0) {
		$query = $this->db->query("SELECT e.id, e.exam_name, e.exam_duration, e.total_questions, e.total_marks, e.description, eq.questions FROM xtra_exam_questions as eq JOIN xtra_exam as e ON eq.exam_id = e.id WHERE e.active = 1 AND eq.active = 1 AND e.id = ${exam_id}");
		return $query->row();
	}




	public function getQuestions($questions) {
		$query = $this->db->query("SELECT q.id as question_id, q.question, q.question_time FROM xtra_question as q WHERE q.id IN ($questions) AND q.active = 1");
		return $query->result_array();
	}


	public function getOptions($questions) {
		$query = $this->db->query("SELECT so.option_id, so.question_id, so.option_key, so.option_val FROM xtra_single_options as so WHERE so.question_id IN ($questions) AND so.active = 1");
		return $query->result_array();
	}





}