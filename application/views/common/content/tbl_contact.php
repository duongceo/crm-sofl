

<?php if ($this->total_paging > 0) { ?>

    <div class="pagination">

        <?php echo isset($pagination) ? $pagination : ''; ?>

    </div>

    <div class="number_paging" id="paging">

        <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' contacts'; ?>

    </div>

	<?php $class_contact = ($this->agent->is_mobile()) ? '' : 'list_contact list_contact_2';?>

	<div class="table-responsive">

		<table class="table table-bordered table-expandable table-striped table-fixed-head <?php echo $class_contact;?>">
		
			<colgroup>
                <?php if ($table[0] == 'selection') { ?>
                    <col style="width: 2%;"/>
				<?php } ?>
                <col style="width: 10%;"/>
                <col style="width: 8%;"/>
            </colgroup>

			<thead>

				<tr>

					<?php

					if (isset($table)) {

						foreach ($table as $value) {

							$this->load->view('common/content/table/head/' . $value);

						}

					}

					?>

				</tr>

			</thead>

			<tbody>

				<?php

				if (isset($contacts)) {

					foreach ($contacts as $key => $value) {

						?>

						<tr class="custom_right_menu <?php echo h_get_row_class($value); ?>"

							contact_id="<?php echo $value['id']; ?>"

							item_id="<?php echo $value['id']; ?>"

							duplicate_id="<?php echo $value['duplicate_id']; ?>"

							contact_name="<?php echo $value['name']; ?>"

							contact_phone="<?php echo $value['phone']; ?>">

								<?php

								$idRandom = h_generateRandomString();

								$data['value'] = $value;

								$data['id_random'] = $idRandom;

								foreach ($table as $value2) {

									$this->load->view('common/content/table/body/' . $value2, $data);

								}

								?>

						</tr>

						<?php

					}

				}

				?>

			</tbody>

		</table>

	</div>
	
	<div class="paging_down">
	
		<!-- <?php //if (empty($sale_call_process)) { ?> -->
		<div class="pagination">

			<?php echo isset($pagination) ? $pagination : ''; ?>

		</div>
		
		<div class="number_paging"> 

			<?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' contacts'; ?>

		</div>
		<!-- <?php //} ?> -->

	</div>

<?php } ?>
