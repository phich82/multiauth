@push('styles')
<style>
    .popup .modal-header {
        display: flex;
        align-items: center;
    }

    .popup .modal-header .close {
        padding: 0 !important;
        margin: 0 !important;
    }

    .popup .modal-title {
        display: flex !important;
        align-items: center !important;
        font-weight: bold;
    }

    .popup .modal-title i {
        margin-right: 5px !important;
    }
</style>
@endpush
<div class="modal popup" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Popup title</h5>
                <button type="button" class="close" onclick="popup.close()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-message">Popup content here.</div>
            </div>
            <div class="modal-footer modal-footer-multiple">
                <button type="button" class="btn btn-primary btnSaveModal" onclick="popup.yes(this)">OK</button>
                <button type="button" class="btn btn-secondary btnCancelModal" onclick="popup.no(this)">Cancel</button>
            </div>
            <div class="modal-footer modal-footer-single" style="display: none;">
                <button type="button" class="btn btn-primary btnCloseModal" onclick="popup.no(this)">Close</button>
            </div>
        </div>
    </div>
</div>
