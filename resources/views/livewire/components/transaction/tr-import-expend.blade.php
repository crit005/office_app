<div wire:ignore.self class="modal fade blur-bg-dialog " id="importPaymentFormModal" tabindex="-1" role="dialog"
    aria-labelledby="importPaymentFormModalTitle" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-pament modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-blur-light-red">
            <div class="modal-header">
                <div class="w-100 d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="modal-title text-white" id="exampleModalLongTitle">
                            Import Payment
                        </h5>
                    </div>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form wire:submit.prevent='{{ $showEditModal ? ' updateDepatment' : 'createDepatment' }}'> --}}
            <form >
                <div class="modal-body m-0 border-radius-0 bg-white">
                    <div class="row">

                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th style="width: 100px;">Name</th>
                            <th style="width: 50px;">Type</th>
                            <th style="width: 50px;">Default</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>backdrop</td>
                            <td>boolean or the string <code>'static'</code></td>
                            <td>true</td>
                            <td>Includes a modal-backdrop element. Alternatively, specify <code>static</code> for a backdrop which doesn't close the modal on click.</td>
                          </tr>
                          <tr>
                            <td>keyboard</td>
                            <td>boolean</td>
                            <td>true</td>
                            <td>Closes the modal when escape key is pressed</td>
                          </tr>
                          <tr>
                            <td>focus</td>
                            <td>boolean</td>
                            <td>true</td>
                            <td>Puts the focus on the modal when initialized.</td>
                          </tr>
                          <tr>
                            <td>show</td>
                            <td>boolean</td>
                            <td>true</td>
                            <td>Shows the modal when initialized.</td>
                          </tr>
                        </tbody>
                      </table>
                    <!-- /Ended row -->

                </div> <!-- end modal-body -->

                <div class="modal-footer">

                    <div class="d-flex text-sm justify-content-between" style="width: 100%;">
                        <div>
                            <button type="button" class="btn btn-secondary"data-dismiss="modal">
                                <i class="fa fa-times mr-2"></i>Cancel</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i
                                    class="fa fa-save mr-2"></i>Save</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        window.addEventListener('show-import-payment-form', e => {
            $('#importPaymentFormModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        window.addEventListener('hide-import-payment-form', e => {
            $('#importPaymentFormModal').modal('hide');
        });



        $('.modal-dialog-pament').draggable({
            handle: ".modal-header"
        });
    </script>
@endpush

