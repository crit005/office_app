@props(['id','error','format','viewMode','minDate','maxDate'])
{{-- @dump($minDate) --}}
<input {{$attributes}} type="text" class="form-control datetimepicker-input @error($error)
        is-invalid
        @else {{$this->getValidClass($error)}}
    @enderror" id="{{$id}}" data-toggle="datetimepicker" data-target="#{{$id}}"
    data-mindate="{{$minDate?? env('MINDATE')}}"
    data-maxdate="{{$maxDate?? env('MAXDATE')}}"
    onchange="this.dispatchEvent(new InputEvent('input'))" />

@push('js')
<script type="text/javascript">
    $(function(e){

    $('#{{$id}}').datetimepicker({
            format:"{{$format?? 'L'}}",
            defaultDate:moment().toDate(),
            // format:'L',
            viewMode:"{{$viewMode ?? 'days'}}",
            // minDate:moment(05/13/2022,'MMM/d/Y'),
            minDate:moment($('#{{$id}}').data("mindate"),'MMM/d/Y'),
            maxDate:moment($('#{{$id}}').data("maxdate"),'MMM/d/Y'),
        });
})

</script>
@endpush
