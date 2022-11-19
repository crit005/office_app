@props(['colorPalates'])

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" style="width:880px" role="document">
    <div class="modal-content">
        <div class="modal-header border-bottom-0 pb-0">
            <h1 class="modal-title text-center w-100" id="exampleModalLabel">Color Palette</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pt-0">
            <div class="row">
                @forelse ($colorPalates as $index => $color)
                    @if ($index == 0 || $colorPalates[$index -1]->palet_name != $color->palet_name)
                    <div class="col-lg-4 mb-2"> <!--1-->
                        <div class="color-title">{{$color->palet_name}}</div>
                        <div class="color-conainner d-flex flex-row"> <!--2-->
                    @endif
                            <div class="color-label-conainner" onclick="tmpColorSet('{{$color->bg_color}}','{{$color->text_color}}')" {{$color->getInlineStyleSet()}}>Sample</div>
                    @if ($index == count($colorPalates)-1 || $colorPalates[$index +1]->palet_name != $color->palet_name)
                        </div> <!--/2-->
                    </div> <!--/1-->
                    @endif
                @empty
                    <div class="w-100 text-center">Sorry, No Template Here!</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>

@push('js')
    <script>
    function tmpColorSet(tmpColorBgValue, tmpColorValue){
        // main component must has function setProp take 2 variables prop and value
        // @this.setProp(field,value);
        @this.setColorStyle(tmpColorBgValue,tmpColorValue);
        $('#exampleModal').modal('hide');
    }
    </script>
@endpush
