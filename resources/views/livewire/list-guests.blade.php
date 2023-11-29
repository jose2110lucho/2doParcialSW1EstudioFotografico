

<div class="card" style="background-color: beige">
    <div class="card-header">
        <h1 style="text-align: center"><strong>Lista de invitados</strong></h1>
    </div>
    <div class="card-body">
        <div>
            {{-- <h1 style="text-align: center"><strong>Lista de invitados</strong></h1> --}}
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#inviteModal" style="border-radius: 20px; margin-bottom: 20px;">Invitar</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->guests as $item)
                        <tr>
                            <td scope="row">{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                        </tr>
                    @endforeach
        
                </tbody>
            </table>
        
            <x-modal id="inviteModal" title="Nueva invitación">
                <x-slot name="body">
                    <form id="invitationForm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">@</span>
                            </div>
                            <input wire:model='emailReceiver' class="form-control" placeholder="email" type="email"
                                id="emailReceiver" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" wire:click='send' id="sendButton"
                                    wire:loading.attr="disabled">Enviar</button>
                            </div>
                        </div>
                        @error('emailReceiver')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </form>
                    <div class="table-responsive p-0" style="height: 550px;">
                        <table class="table table-head-fixed">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invitations as $item)
                                    <tr>
                                        <td scope="row">{{ $item->email_receiver }}</td>
                                        <td>{{ $item->send_date }}</td>
                                        <td>
                                            @switch($item->status)
                                                @case(0)
                                                    <span class="badge badge-pill badge-secondary">enviado</span>
                                                @break
        
                                                @case(1)
                                                    <span class="badge badge-pill badge-success">aceptado</span>
                                                @break
        
                                                @case(2)
                                                    <span class="badge badge-pill badge-danger">rechazado</span>
                                                @break
        
                                                @default
                                            @endswitch
        
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-slot>
            </x-modal>
        </div>
    </div>
  </div>
</div>


@push('js')
    <script src="{{ asset('js/crud_resources.js') }}"></script>
@endpush
