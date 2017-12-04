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



	public function () {
		$query = "SELECT es.id as schedule_id, e.id as exam_id, es.schedule_name, es.description as schedule_description, es.start_date, es.end_date, es.result_date, es.offered_as, es.offer_cost, es.result_as, es.schedule_to, e.exam_duration, e.total_questions, e.total_marks, e.description as exam_description  FROM xtra_exam_schedule_batchs as esb JOIN xtra_exam_schedule as es ON esb.schedule_id = es.id JOIN xtra_exam as e ON es.exam_id = e.id WHERE es.active = 1 AND e.active = 1 AND esb.active = 1";
		return $query->row();
	}
}