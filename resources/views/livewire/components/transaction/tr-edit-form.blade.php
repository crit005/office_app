<form action="" class="">
    <div class="inline-form m-0 row">

        <div class="form-group col-md-2 col-sm-6">
            <label for="exampleFormControlSelect1">Date</label>
            <x-datepicker-normal id="date" :format="'DD-MMM-Y'"
                :placeholder="'From'" :classes="'form-control-sm'" />
        </div>

        <div class="form-group col-md-3 col-sm-6">
            <label for="exampleFormControlSelect1">Pament</label>
            <select class="form-control form-control-sm"
                id="exampleFormControlSelect1">
                <option>Travel</option>
                <option>Passport</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>

        <div class="form-group col-md-2 col-sm-6">
            <label for="exampleFormControlSelect1">Currency</label>
            <select class="form-control form-control-sm"
                id="exampleFormControlSelect1">
                <option>USD</option>
                <option>THB</option>
                <option>RIAL</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="form-group col-md-2 col-sm-6">
            <label for="exampleFormControlSelect1">Amount</label>
            <input class="form-control form-control-sm" type="text"
                placeholder="Amount">
        </div>

        <div class="form-group col-md-3 col-sm-6">
            <label for="exampleFormControlSelect1">Pay On</label>
            <select class="form-control form-control-sm"
                id="exampleFormControlSelect1">
                <option selected>Selected..</option>
                <option value="1">ACC</option>
                <option value="2">BANDA</option>
                <option value="3">CBO</option>
            </select>
        </div>

        <div class="form-group row col-md-10 col-sm-6 pr-0">
            <label for="exampleFormControlTextarea1"
                class="col-sm-12 col-md-2 col-form-label pt-0">Detail</label>
            <div class="col-sm-12 col-md-10 m-md-0 p-0">
                <textarea class="form-control form-control-sm" rows="1" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>

        <div
            class="form-group col-md-2 d-flex flex-col justify-content-center">
            <button type="button"
                class="btn btn-primary btn-sm ml-2 w-32"
                style="width:45%"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-danger btn-sm ml-2 w-32"
                style="width:45%"><i
                    class="fas fa-trash"></i></i></button>
        </div>

        <div class="text-sm text-gray row w-100">
            <div class="col-md-6 d-flex flex-col justify-content-md-start w-100">
                <div class="mr-2">Created_at: 12-10-2022</div>
                <div>Created_by:: Anen</div>
            </div>
            <div class="col-md-6 d-flex flex-col justify-content-md-end w-100">
                <div class="mr-2">Updated_at: 12-10-2022</div>
                <div>Updated_by: Anen</div>
            </div>
        </div>

    </div>
</form>
