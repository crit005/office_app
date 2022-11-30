@props(['id','format','viewMode','minDate','maxDate','placeholder','classes','linked'=>null])
{{-- @dump($minDate) --}}
<input {{$attributes}} type="text" class="form-control datetimepicker-input {{$classes?? ''}}"
    id="{{$id}}" data-toggle="datetimepicker" data-target="#{{$id}}"
    data-mindate="{{$minDate?? env('MINDATE')}}"
    data-maxdate="{{$maxDate?? env('MAXDATE')}}"
    placeholder="{{$placeholder?? ''}}"
    onchange="this.dispatchEvent(new InputEvent('input'))"
    autocomplete="off"/>

@push('js')
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
        @if ($linked)
            $('#{{$id}}').on("change.datetimepicker", function (e) {
                $('#{{$linked}}').datetimepicker('minDate', e.date);
            });
            $("#{{$linked}}").on("change.datetimepicker", function (e) {
                $('#{{$id}}').datetimepicker('maxDate', e.date);
            });
        @endif
    })

</script>
@endpush
