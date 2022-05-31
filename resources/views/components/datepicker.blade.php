@props(['id','error','format','viewMode'])
{{-- {{dump($id)}} --}}

<input {{$attributes}} type="text" class="form-control datetimepicker-input @error($error)
        is-invalid
        @else {{$this->getValidClass($error)}}
    @enderror" id="{{$id}}" data-toggle="datetimepicker" data-target="#{{$id}}"
    onchange="this.dispatchEvent(new InputEvent('input'))" />

@push('js')
<script type="text/javascript">
    $('#{{$id}}').datetimepicker({
            format:"{{$format?? 'L'}}",
            defaultDate:moment().toDate(),
            // format:'L',
            viewMode:"{{$viewMode ?? 'days'}}",
        });

</script>
@endpush
