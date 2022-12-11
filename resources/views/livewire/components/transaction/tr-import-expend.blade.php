<div wire:ignore.self class="modal fade blur-bg-dialog " id="importPaymentFormModal" tabindex="-1" role="dialog"
    aria-labelledby="importPaymentFormModalTitle" aria-hidden="true">
    {{-- <div wire:ignore.self class="modal-dialog modal-dialog-pament modal-dialog-centered modal-xl" role="document"> --}}
        <div wire:ignore.self class="modal-dialog modal-dialog-import modal-dialog-max" role="document">
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
                    <form>
                        <div wire:ignore.self class="modal-body m-0 border-radius-0 bg-white import-modal-body">
                            {{-- @dump(count($errors)) --}}
                            {{-- @dump($dataRows) --}}
                            {{-- @dump($test) --}}
                            <div class="row">
                                <div wire:ignore class="col">
                                    <div class="form-group form-group-sm">
                                        <div class="input-group input-group-sm">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="excelInputFile"
                                                    accept=".xlsx,.xls,.csv">
                                                <label class="custom-file-label" id="lblExcelInputFile"
                                                    for="excelInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group sort-input-date">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01"><i
                                                    class="fas fa-money-bill"></i></label>
                                        </div>
                                        <select wire:model="currencyId" class="custom-select selectpicker">
                                            <option value="" selected>* Currency</option>
                                            @foreach ($currencys as $currency)
                                            <option value={{$currency->id}}>{{$currency->symbol}} {{$currency->code}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            @if ($importData && count($importData)>=5)
                                <table class="table table-v1 table-excel table-hover">
                                    <thead>
                                        <tr class="tr-th-border-0 stick-top-0">
                                            <th scope="col" class="text-center text-lg vertical-middle th-excel"
                                                colspan="{{count($importData[0])}}">{{$importData[0][0]}}</th>
                                        </tr>
                                        <tr class="tr-th-border-0 stick-top-0">
                                            <th scope="col" class="text-lg vertical-middle th-excel"
                                                colspan="{{count($importData[1])}}">
                                                {{date('M-Y',strtotime($importData[1][0]))}}</th>
                                        </tr>
                                        <tr class="tr-th-border-0 stick-top-0">
                                            <th scope="col"
                                                class="text-center text-warning text-nowrap text-sm vertical-middle th-excel"
                                                rowspan="2">{{$importData[2][0]}}</th>
                                            <th scope="col"
                                                class="text-center text-warning text-nowrap text-sm vertical-middle th-excel"
                                                rowspan="2">{{$importData[2][1]}}</th>
                                            <th scope="col"
                                                class="text-center text-warning text-nowrap text-sm vertical-middle th-excel"
                                                rowspan="2">{{$importData[2][2]}}</th>
                                            <th scope="col"
                                                class="text-center text-warning text-nowrap text-sm vertical-middle th-excel"
                                                colspan="{{count($importData[1])-6}}">{{$importData[2][3]}}</th>
                                            <th scope="col"
                                                class="text-center text-warning text-nowrap text-sm vertical-middle th-excel"
                                                rowspan="2">{{$importData[2][count($importData[1])-3]}}</th>
                                            <th scope="col"
                                                class="text-center text-warning text-nowrap text-sm vertical-middle th-excel"
                                                rowspan="2">{{$importData[2][count($importData[1])-2]}}</th>
                                            <th scope="col"
                                                class="text-center text-warning text-nowrap text-sm vertical-middle th-excel"
                                                rowspan="2">{{$importData[2][count($importData[1])-1]}}</th>
                                        </tr>
                                        <tr class="tr-th-border-0 stick-top-0">
                                            @foreach ( $importData[3] as $index => $item )
                                            @if ($item)
                                            <th scope="col"
                                                class="text-center  text-info text-nowrap text-sm vertical-middle th-excel">
                                                {{$item}}
                                                @error('inputItems.'.$index)
                                                {{-- <span class="text-danger">[x]</span> --}}
                                                <span class="text-danger import-error" role="button" onclick="toastError('{{$message}}')" >[?]</span>
                                                @enderror
                                            </th>
                                            @endif
                                            @endforeach
                                        </tr>
                                    </thead>
                                    {{-- <tbody id="sortable" class="@if(count($errors)>0) table-zibra-red @else table-zibra-green @endif"> --}}
                                    <tbody id="sortable" class="table-zibra-green">
                                        <?php $k = 0 ?>
                                        @forelse ($importData as $indext => $data)
                                        @if ($indext >3)
                                        <tr>
                                            @foreach ($data as $i => $val)
                                            <td scope="col" class="text-center text-nowrap th-excel">
                                                @if($i==0)
                                                {{date('d-m-Y',strtotime($val))}}
                                                @else
                                                {{$val}}
                                                @endif
                                                @error('dataRows.'.($k).'.'.$i)
                                                    {{-- <span class="text-danger import-error">[x]</span>  --}}
                                                    <span class="text-danger import-error" role="button" onclick="toastError('{{$message}}')" >[?]</span>
                                                @enderror
                                            </td>
                                            @endforeach
                                        </tr>
                                        <?php $k += 1 ?>
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

                            {{-- <div class="d-flex text-sm justify-content-between" style="width: 100%;">
                                <div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fa fa-times mr-2"></i>Cancel</button>
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i
                                            class="fa fa-save mr-2"></i>Save</button>
                                </div>
                            </div> --}}
                            <div class="row w-100">
                                <div class="col text-left text-white float-left">
                                    <span>Total: {{(count($importData)-4)>0?count($importData)-4:0}} records</span>
                                </div>
                                <div class="col col-auto">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fa fa-times mr-2"></i>Cancel</button>
                                </div>
                                <div class="col col-auto">
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


        $('.modal-dialog-import').draggable({
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
            $('#importPaymentFormModal').on('hidden.bs.modal', function (e) {
                $("#excelInputFile").val(null);
                $('#lblExcelInputFile').html('Choose file');
                @this.resetImportData();
            })
            $('#excelInputFile').on('click',function(){
               $("#excelInputFile").val(null);
            });
            $('#excelInputFile').on('change',function(){
                submitImportData();

            });

        });

        function submitImportData(){
            let importFile = $("#excelInputFile")[0].files[0];
                if(importFile){
                    if (!(/\.(xlsx|xls)$/i).test(importFile.name)) {
                    alert('Please select a valid excel file(xlsx or xls).');
                    $("#excelInputFile").val(null);
                    importFile = null;
                    }else{
                        $('#lblExcelInputFile').html(importFile? importFile.name : 'Choose file');
                        readXlsxFile(importFile).then(function(rows) {
                            // $("#excelInputFile").val(null);
                            if(rows.length >=5){
                                @this.setImportData(rows);
                            }else{
                                alert('Invalid data');
                                $("#excelInputFile").val(null);
                                $('#lblExcelInputFile').html('Choose file');
                                @this.setImportData([]);
                            }
                        })
                    }
                }else{
                    alert('nofile selected');
                }
        }
    </script>
    @endpush
