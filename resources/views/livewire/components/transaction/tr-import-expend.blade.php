<div wire:ignore.self class="modal fade blur-bg-dialog " id="importPaymentFormModal" tabindex="-1" role="dialog"
    aria-labelledby="importPaymentFormModalTitle" aria-hidden="true">
    {{-- <div wire:ignore.self class="modal-dialog modal-dialog-pament modal-dialog-centered modal-xl" role="document"> --}}
    <div wire:ignore.self class="modal-dialog modal-dialog-pament modal-dialog-max" role="document">
        <div class="modal-content modal-blur-light-red modal-dialog-import-pament">
            <div class="modal-header import-modal-header">
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
                <div class="modal-body m-0 border-radius-0 bg-white import-modal-body">
                    @dump($items)
                    @dump($errors)
                    <div class="row">
                        <div class="col">
                            <div wire:ignore class="form-group form-group-sm">
                                {{-- <label for="exampleInputFile">File input</label> --}}
                                <div class="input-group input-group-sm">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="excelInputFile" accept=".xlsx,.xls,.csv">
                                        {{-- <input type="file" class="custom-file-input" id="excelInputFile"> --}}
                                        <label class="custom-file-label" id="lblExcelInputFile" for="excelInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="input-group input-group-sm  sort-input-date elevation-1">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-money-bill"></i></label>
                                </div>
                                <select wire:model="currencyId" class="custom-select selectpicker">
                                    <option value="" selected>* Currency</option>
                                    @foreach ($currencys as $currency)
                                    <option value={{$currency->id}}>{{$currency->symbol}} {{$currency->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                        @if ($importData)
                        {{-- <table class="table table-v1 table-hover"> --}}
                        <table class="table table-v1 table-excel table-hover">
                            <thead>
                                <tr class="tr-th-border-0 stick-top-0">
                                    <th scope="col" class="text-center text-lg vertical-middle th-excel" colspan="{{count($importData[0])}}">{{$importData[0][0]}}</th>
                                </tr>
                                <tr class="tr-th-border-0 stick-top-0">
                                    <th scope="col" class="text-lg vertical-middle th-excel" colspan="{{count($importData[1])}}">{{date('M-Y',strtotime($importData[1][0]))}}</th>
                                </tr>
                                <tr class="tr-th-border-0 stick-top-0">
                                    <th scope="col" class="text-center text-warning text-nowrap text-sm vertical-middle th-excel" rowspan="2">{{$importData[2][0]}}</th>
                                    <th scope="col" class="text-center text-warning text-nowrap text-sm vertical-middle th-excel" rowspan="2">{{$importData[2][1]}}</th>
                                    <th scope="col" class="text-center text-warning text-nowrap text-sm vertical-middle th-excel" rowspan="2">{{$importData[2][2]}}</th>
                                    <th scope="col" class="text-center text-warning text-nowrap text-sm vertical-middle th-excel" colspan="{{count($importData[1])-6}}">{{$importData[2][3]}}</th>
                                    <th scope="col" class="text-center text-warning text-nowrap text-sm vertical-middle th-excel" rowspan="2">{{$importData[2][count($importData[1])-3]}}</th>
                                    <th scope="col" class="text-center text-warning text-nowrap text-sm vertical-middle th-excel" rowspan="2">{{$importData[2][count($importData[1])-2]}}</th>
                                    <th scope="col" class="text-center text-warning text-nowrap text-sm vertical-middle th-excel" rowspan="2">{{$importData[2][count($importData[1])-1]}}</th>
                                </tr>
                                <tr class="tr-th-border-0 stick-top-0">
                                    @foreach ( $importData[3] as $index => $item )
                                        @if ($item)
                                        <th scope="col" class="text-center  text-info text-nowrap text-sm vertical-middle th-excel">{{$item}}
                                            @error('items.'.$index) <span class="text-danger">[x]</span> @enderror </th>
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                {{-- <tr>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                    <td scope="col" class="text-center text-nowrap"></td>
                                </tr> --}}

                                @forelse ($importData as $indext => $data)
                                @if ($indext >3)
                                <tr>
                                    @foreach ($data as $val)
                                    <td scope="col" class="text-center text-nowrap th-excel">{{$val}}</td>
                                    @endforeach
                                </tr>
                                @endif
                                @empty
                                <tr class="bg-wite">
                                    <td colspan="14" class="text-center"> No record found...</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endif




                </div> <!-- end modal-body -->

                <div class="modal-footer import-modal-footer">

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
<script src="{{ asset('backend/dist/js/excel/read-excel-file.min.js') }}"></script>

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

        $(function(){
            $('#importPaymentFormModal').on('shown.bs.modal',function(e){
                let importModelHeaderH = $('.import-modal-header').height();
                let importModelFooterH = $('.import-modal-footer').height();
                let screenH = window.innerHeight;
                $('.import-modal-body').css({'min-height':((screenH * 0.84) - (importModelHeaderH + importModelFooterH))});
            });
            // $('#importPaymentFormModal').on('show.bs.modal',function(e){
            //     let screenW = window.innerWidth;
            //     $('.modal-dialog-import-pament').width((screenW * 0.84));
            // });
           $('#excelInputFile').on('change',function(){
            // let fileInput = document.getElementById('excelInputFile');
            // let filename = fileInput.files[0].name;

            let importFile = $("#excelInputFile")[0].files[0];
            if(importFile){
                if (!(/\.(xlsx|xls)$/i).test(importFile.name)) {
                alert('Please select a valid excel file(xlsx or xls).');
                $("#excelInputFile").val(null);
                importFile = null;
                }else(
                    readXlsxFile(importFile).then(function(rows) {
                        @this.setImportData(rows);
                    })
                )
            }
            $('#lblExcelInputFile').html(importFile? importFile.name : 'Choose file');
            });

        });
    </script>
@endpush

