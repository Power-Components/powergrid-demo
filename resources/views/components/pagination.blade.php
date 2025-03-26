<div class="bg-warning text-warning-content p-1 rounded-md my-2 w-full">
   Custom Paginator Component:

    @if ($paginator->hasPages())
            @foreach ($elements as $element)
                @foreach ($element as $pageNumber => $url)
                   <a class="cursor-pointer underline" wire:click="gotoPage({{ $pageNumber }}, 'page')"> Page {{ $pageNumber }}</a>
                  @endforeach
              @endforeach
     @endif
  <br/>
  (user wants {{ $perPage }} records per page).
</div>
