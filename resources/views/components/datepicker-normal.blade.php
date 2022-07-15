@props(['id','format','viewMode','minDate','maxDate'])
{{-- @dump($minDate) --}}
<input {{$attributes}} type="text" class="form-control datetimepicker-input"
    id="{{$id}}" data-toggle="datetimepicker" data-target="#{{$id}}"
    data-mindate="{{$minDate?? env('MINDATE')}}"
    data-maxdate="{{$maxDate?? env('MAXDATE')}}"
    onchange="this.dispatchEvent(new InputEvent('input'))" />

@push('js')
<script type="text/javascript">
    $(function(e){
    $('#{{$id}}').datetimepicker({
            format:"{{$format ?? 'L'}}",
            // defaultDate:moment().toDate(),
            // format:'L',
            viewMode:"{{$viewMode ?? 'days'}}",
        });
})

</script>
@endpush
