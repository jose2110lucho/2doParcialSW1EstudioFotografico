@props(['id', 'title', 'actionClose' => null, 'actionLoading' => null])
<div wire:ignore.self class="modal fade" id="{{ $id }}" name="{{ $id }}"
    aria-labelledby="addWordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="{{ $actionClose }}">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @if ($actionLoading)
                <div wire:loading wire:target='{{ $actionLoading }}'>
                    <div class="overlay">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                </div>
            @endif
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click="{{ $actionClose }}">Cerrar</button>
            </div>
        </div>
    </div>
</div>
