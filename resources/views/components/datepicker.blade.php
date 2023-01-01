@props(['id','error','format','viewMode','minDate','maxDate','default','moreclass'])
{{-- @dump($minDate) --}}
<input {{$attributes}} type="text" class="form-control datetimepicker-input {{$moreclass??''}} @error($error)
        is-invalid
        @else {{$this->getValidClass($error)}}
    @enderror" id="{{$id}}" data-toggle="datetimepicker" data-target="#{{$id}}"
    data-mindate="{{$minDate?? env('MINDATE')}}"
    data-maxdate="{{$maxDate?? env('MAXDATE')}}"
    onchange="this.dispatchEvent(new InputEvent('input'))"
    autocomplete="off" />

{{-- @push('js') --}}
<script type="text/javascript">
    $(function(e){
    $('#{{$id}}').datetimepicker({
            // locale: moment.locale('km'),
            format:"{{$format ?? 'L'}}",
            // defaultDate:moment().toDate(),
            // defaultDate: moment().format(),
            // format:'L',
            viewMode:"{{$viewMode ?? 'days'}}",
            useCurrent: false
        });
})

</script>
{{-- @endpush --}}
