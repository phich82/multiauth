{{-- <div class="container popup" style="display: none;">
	<div class="row">
	<div class="modal-content">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    		<h4 class="modal-title">Header Title</h4>
    	</div>
		<div class="modal-body">
			<label class="modal-message">Email Address</label>
		</div>
		<div class="modal-footer">
			<button class="btn btn-success btn-icon" onclick="popup.yes(this)"><i class="fa fa-check"></i> OK</button>
			<button class="btn btn-default btn-icon" onclick="popup.yes(this)" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
		</div>
    </div>
	</div>
</div> --}}
<div class="modal popup" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" onclick="popup.close()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-message">Modal body text goes here.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btnSaveModal" onclick="popup.yes(this)">Save</button>
                <button type="button" class="btn btn-secondary btnCancelModal" onclick="popup.no(this)" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
