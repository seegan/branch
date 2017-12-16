<div class="content-page-instruction">
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="text-center">


				    <div class="col-lg-12">
				        <table class="table table-bordered">
				            <thead>
				                <tr>
				                    <th>Name</th>
				                    <th>Exam Duration</th>
				                    <th>Start Date</th>
				                    <th>End Date</th>
				                    <th>Result Date</th>
				                    <th>Offered As</th>
				                    <th>Cost</th>
				                </tr>
				            </thead>
				            <tbody>
				            <?php
				            if($schedule_data) {
				            ?>
				                <tr>
				                    <td><?php echo $schedule_data->schedule_name; ?></td>
				                    <th><?php echo secondsToHuman($schedule_data->exam_duration); ?></th>
				                    <td><?php echo $schedule_data->start_date; ?></td>
				                    <td><?php echo $schedule_data->end_date; ?></td>
				                    <td><?php echo $schedule_data->result_date; ?></td>
				                    <td><?php echo ucfirst( $schedule_data->offered_as ); ?></td>
				                    <td><?php echo $schedule_data->offer_cost; ?></td>
				                </tr>
				            <?php
				            }
				            ?>
				            </tbody>
				        </table>
				    </div>

				    <div class="col-lg-12">

					    <div class="result-data" style="width:600px;margin:0 auto;">
					    	<div style="text-align:center;">
					    		<h3 style="margin-top:20px;margin-bottom:20px;">
					    			<?php echo $main_content; ?>
					    		</h3>
					    	</div>
					        <table class="table table-bordered">
					            <thead>
					                <tr>
					                    <th>Name</th>
					                    <th>Data</th>
					                </tr>
					            </thead>
					            <tbody>
					                <tr>
					                    <td>dfdf</td>
					                    <th>fdhg</th>
					                </tr>
					            </tbody>
					        </table>
					    </div>
				    </div>

				</div>
			</div>
		</div>
	</div>	
</div>