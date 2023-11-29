<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\User;
use App\Services\InvitationService;
use Livewire\Component;

class ListPhotographers extends Component
{
    private $titlePage = 'Evento | Fotógrafos';
    public $eventId, $event, $invitations;
    public $allUsers = [], $photographer;

    public function mount(int $event)
    {
        $this->eventId = $event;
        $this->getPhotographersInvitated();
        $this->getallUsers();
    }

    public function render()
    {
        return view('livewire.list-photographers')->title($this->titlePage);
    }

    private function getPhotographersInvitated()
    {
        $invitations = [];
        $event = Event::find($this->eventId);
        $this->event = $event;

        foreach ($event->photographersInvited as $item) {
            $invitations[] = [
                'name' => $item->name,
                'date' => $item->pivot->updated_at->format('d/m/y H:i:s'),
                'status' => $item->pivot->status,
            ];
        }
        $this->invitations = collect(json_decode(json_encode($invitations)));
    }

    private function getallUsers()
    {
        $event = Event::find($this->eventId);
        $this->allUsers = User::all()
            ->where('id', '!=', $event->user_id)
            ->whereNotIn('id', $event->photographers->pluck('id'))
            ->whereNotIn('id', $event->guests->pluck('id'));
    }

    public function send()
    {
        $this->validate([
            'photographer' => 'required',
        ]);
        $event = Event::find($this->eventId);
        $photographer = User::find($this->photographer);
        $sendResponse = InvitationService::createPhotographerInvitation($event, $photographer);

        if ($sendResponse['status'] == 'success') {
            $this->getPhotographersInvitated();
        }
        $this->dispatch('new-message', $sendResponse);
    }
}
