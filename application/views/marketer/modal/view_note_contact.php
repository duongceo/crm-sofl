<div class="modal fade note_contact_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel">Ghi chú cho contact "<span class="contact_name"> </span>"</h4>

            </div>

            <div class="modal-body">

                <form action="" method="POST">

                    <input type="hidden" name="contact_id" id="contact_id_input_note"/>

					<div class="radio-inline">
						<label>
							<input type="radio" name="check_contact" value="0">
							Để sale chăm sóc lại
						</label>
					</div>

					<div class="radio-inline">
						<label>
							<input type="radio" name="check_contact" value="1">
							Đồng ý là contact chết
						</label>
					</div>

					<div class="radio-inline">
						<label>
							<input type="radio" name="check_contact" value="2">
							Contact Online
						</label>
					</div>

                    <div class="form-group">

                        <label> Ghi chú </label>

                        <textarea class="form-control" rows="3" name="note" id="note"></textarea>

                    </div>

                    <div class="form-group">

                        <input class="btn btn-success btn-block btn-lg btn-note-contact" type="submit" value="OK" />

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>
