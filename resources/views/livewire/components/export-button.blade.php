<div class="d-flex flex-row float-left" wire:poll>
    @if (!$exporting)
        <button onclick="protectedDownload()" class="btn btn-success btn-sm elevation-1">
            <i class="far fa-file-excel"></i>
        </button>
    @endif

    <div wire:poll='checkExportJob()'>
        @if ($exporting)
            <div class="customer-list-exporting text-white ml-2 text-nowrap">
                @if ($exporting['status'] == 'PROCESSING')
                    <i class="fas fa-spinner fa-spin align-self-center"></i>
                    Exporting...
                @else
                    Your Export is ready
                    {{-- <button wire:click.prevent="$emit('ListCustomer_DoDeleteExport',$exporting)" class="btn btn-danger btn-sm elevation-1">
                        <i class="fas fa-trash"></i>
                    </button>
                    doDeleteExport--}}
                    <button wire:click.prevent="doDeleteExport_F" class="btn btn-danger btn-sm elevation-1">
                        <i class="fas fa-trash"></i>
                    </button>

                    {{-- <button wire:click.prevent="$emit('ListCustomer_DoDownload')" class="btn btn-success btn-sm elevation-1"> --}}
                    <button wire:click.prevent="doDownload_F" class="btn btn-success btn-sm elevation-1">
                        <i class="fas fa-download"></i>
                    </button>
                @endif
            </div>
        @endif
    </div>

</div>

@push('js')
    <script>
        // window.addEventListener('protectDownload', e => {
        //     protectedDownload();
        // });

        function protectedDownload(){
            Swal.fire({
                title: 'Protect Your File',
                icon: 'info',
                html: `<input type="text" id="fileName" class="swal2-input" placeholder="File Name">
                    <input type="password" id="password" class="swal2-input" placeholder="Password">
                    <input type="password" id="cpassword" class="swal2-input" placeholder="confirm Password">`,
                confirmButtonText: 'Submit',
                focusConfirm: false,
                preConfirm: () => {
                    const fileName = Swal.getPopup().querySelector('#fileName').value
                    const password = Swal.getPopup().querySelector('#password').value
                    const cpassword = Swal.getPopup().querySelector('#cpassword').value
                    const rg1 =
                        /^[^\\/:\*\?"<>\|\.@\$#]+$/; // forbidden characters \ / : * ? " < > | . @.# $
                    if (!fileName || !password) {
                        Swal.showValidationMessage(`Please enter fiename and password`)
                    } else if (!rg1.test(fileName)) {
                        Swal.showValidationMessage(`Invalid filename`)
                    } else if (password != cpassword) {
                        Swal.showValidationMessage(`Password are not match`)
                    }
                    return {
                        fileName: fileName,
                        password: password
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Livewire.emit('ListCustomer_Doexport',
                    // {
                    //     "fileName": result.value.fileName,
                    //     "password": result.value.password
                    // });
                    @this.doExport({
                        "fileName": result.value.fileName,
                        "password": result.value.password
                    });
                } else {
                    console.log("no result");
                }

            });
        }
    </script>
@endpush
