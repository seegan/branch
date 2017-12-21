<div class="content-page-instruction">
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="text-center">
					<h2>General Instructions</h2>
					<div id="my_camera" style="display:none;"></div>
				</div>
			</div>
		</div>
	</div>	
	<div class="instruction-footer">
		<div class="instruction-foot-content">
			<div class="form-group text-right m-b-0">
				<input type="hidden" id="exam_action" value="instruction">
				<div class="checkbox checkbox-success form-check-inline">
				    <input type="checkbox" id="tos_instruction" value="1">
				    <label for="tos_instruction"> I have Read And Understood the above Instruction </label>
				</div>
	            <button class="btn btn-primary waves-effect waves-light take_schedule_btn" type="button" data-examschedule="<?php echo base_url('online/exam/schedule').'/'.$schedule_id ?>">
	                Take Exam <i class="ion-arrow-right-b"></i>
	            </button>
	        </div>
		</div>
	</div>
</div>
