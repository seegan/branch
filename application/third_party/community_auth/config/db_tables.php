<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Database Tables Config
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

// USER RELATED TABLES
$config['user_table']                   = 'users';

// LOGIN ERROR RELATED TABLES
$config['errors_table']                 = 'login_errors';
$config['IP_hold_table']                = 'ips_on_hold';
$config['username_or_email_hold_table'] = 'username_or_email_on_hold';
$config['denied_access_table']          = 'denied_access';

// SESSION TABLES
$config['sessions_table']               = 'ci_sessions';
$config['auth_sessions_table']          = 'auth_sessions';


$config['candidate_table']              = 'xtra_candidate';

// ACL
$config['acl_categories_table']         = 'acl_categories';
$config['acl_actions_table']            = 'acl_actions';
$config['acl_table']                    = 'acl';

$config['branch_table']            		= 'xtra_branch';
$config['branch_user_table']         	= 'xtra_branch_user';
$config['branch_subject_table']        	= 'xtra_branch_subject';

$config['batch_table']            		= 'xtra_batch';
$config['batch_subject_table']        	= 'xtra_batch_subject';

$config['candidate_branch_batch_table']        	= 'xtra_candidate_branch_batch';

$config['question_table']          		= 'xtra_question';

$config['single_options_table']    		= 'xtra_single_options';
$config['single_answer_table']          = 'xtra_single_answer';


$config['question_type_table']          = 'xtra_question_type';
$config['subject_question_type_table']  = 'xtra_subject_question_type';

$config['subject_table']            	= 'xtra_subject';
$config['subject_topic_table']          = 'xtra_subject_topic';

$config['category_table']            	= 'xtra_category';


$config['exam_table']            		= 'xtra_exam';
$config['exam_questions_table']         = 'xtra_exam_questions';

$config['exam_schedule_table']         = 'xtra_exam_schedule';
$config['exam_schedule_candidate_table']         = 'xtra_exam_schedule_candidates';
$config['exam_schedule_batch_table']         = 'xtra_exam_schedule_batchs';



/* End of file db_tables.php */
/* Location: /community_auth/config/db_tables.php */