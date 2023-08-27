<div>
    <button class="bg-label-danger cursor-pointer px-2 py-2 m-1 rounded-pill bx bx-trash border-0" data-bs-toggle="modal" data-bs-target="#bulkDelete"></button>

    <div class="modal fade" id="bulkDelete" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <h5 class="modal-title text-wrap" id="modalCenterTitle">Are you sure you want to delete {{$name}}?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button wire:key="bulkDelete-{{ uniqid() }}" wire:click="bulkDelete" type="button" class="btn btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
