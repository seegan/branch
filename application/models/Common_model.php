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
		$query = $this->db->query("SELECT c.name, c.enrollment_no, b.name as branch_name   FROM xtra_candidate_branch_batch as cbb JOIN xtra_candidate as c ON cbb.candidate_id = c.user_id JOIN xtra_branch as b ON cbb.branch_id = b.id WHERE b.active = 1 AND cbb.active = 1 AND c.active = 1 AND cbb.branch_id = ".$branch." AND cbb.candidate_id = ".$user);
		return $query->row();
	}
}