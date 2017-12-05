<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Exam Duration</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Result Date</th>
                    <th>Offered As</th>
                    <th>Cost</th>
                    <th style="width:200px;">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($current_exams) {
                $start = 1;
                foreach ($current_exams as $list) {
            ?>
                <tr>
                    <th scope="row"><?php echo $start++; ?></th>
                    <td><?php echo $list->schedule_name; ?></td>
                    <th><?php echo secondsToHuman($list->exam_duration); ?></th>
                    <td><?php echo $list->start_date; ?></td>
                    <td><?php echo $list->end_date; ?></td>
                    <td><?php echo $list->result_date; ?></td>
                    <td><?php echo ucfirst( $list->offered_as ); ?></td>
                    <td><?php echo $list->offer_cost; ?></td>
                    <td>
                        <button type="button" class="btn btn-success btn-custom waves-effect w-md waves-light m-b-5 take_exam_btn" data-examinstruc="<?php echo base_url('online/exam/instruction').'/'.$list->schedule_id; ?>">Take Exam</button>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>