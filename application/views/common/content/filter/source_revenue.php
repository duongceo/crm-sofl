<?php if (isset($source_revenue)) { ?>
	<tr>
		<td class="text-right"> Nguồn doanh thu </td>
		<td>
			<select class="form-control selectpicker" name="filter_source_revenue_id[]" multiple>
				<?php
				foreach ($source_revenue as $key => $value) {
					?>
					<option value="<?php echo $value['id']; ?>"
						<?php
						if (isset($_GET['filter_source_revenue_id'])) {
							foreach ($_GET['filter_source_revenue_id'] as $value2) {
								if ($value2 == $value['id']) {
									echo 'selected';
									break;
								}
							}
						}
						?>>
						<?php echo $value['name']; ?>
					</option>
					<?php
				}
				?>
			</select>
		</td>
	</tr>
<?php } ?>
