@props(['id','error','format','viewMode','minDate','maxDate'])
{{-- {{dump($id)}} --}}

<input {{$attributes}} type="text" class="form-control datetimepicker-input @error($error)
        is-invalid
        @else {{$this->getValidClass($error)}}
    @enderror" id="{{$id}}" data-toggle="datetimepicker" data-target="#{{$id}}"
    onchange="this.dispatchEvent(new InputEvent('input'))" />

@push('js')
<script type="text/javascript">
    // console.log("'{{$minDate ?? false}}'");
    $('#{{$id}}').datetimepicker({
            format:"{{$format ?? 'L'}}",
            defaultDate:moment().toDate(),
            viewMode:"{{$viewMode ?? 'days'}}",
            // minDate:"{{$minDate ?? 'false'}}",
            minDate:moment("{{$minDate ?? env('MINDATE')}}","MM/DD/YYYY"),
            maxDate:moment().toDate()
        });

</script>
@endpush
