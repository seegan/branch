<div class="content-page exam-content">
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="">
							<h2 class="text-center">General Instructions</h2>
							<div class="answer-board inner-board">
								<input type="hidden" id="active_question" value="0">
								<input type="hidden" id="hash_code" value="<?php echo $hash_code; ?>">
								<input type="hidden" id="schedule_id" value="<?php echo $schedule_data->schedule_id; ?>">

							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>




	<div class="instruction-footer">
		<div class="instruction-foot-content">
			<div class="form-group m-b-0">
				<div class="row">
					<div class="col-lg-3">
						<button class="btn btn-primary waves-effect waves-light move_prev" type="button"><i class="ion-arrow-left-b"></i> Previous</button>
						<button class="btn btn-primary waves-effect waves-light move_next" type="button">Next <i class="ion-arrow-right-b"></i></button>
					</div>
					<div class="col-lg-7">
						<button class="btn btn-primary waves-effect waves-light clear_response" type="button">Clear Response</button>
						<button class="btn btn-primary waves-effect waves-light review_next" type="button">Mark for Review & Next</button>
						<button class="btn btn-primary waves-effect waves-light" type="button" >Save & Continue Later</button>
					</div>
					<div class="col-lg-2">
						<div class="text-right">
							<button class="btn btn-primary waves-effect waves-light" type="button" >Submit</button>
						</div>
					</div>
				</div>
	            
	        </div>
		</div>
	</div>

</div>
