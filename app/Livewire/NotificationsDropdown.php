<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\InvitationService;
use Livewire\Component;

class NotificationsDropdown extends Component
{
    public $invitations;


    public function render()
    {
        $this->invitations = auth()->user()->photographerInvitations;
        return view('livewire.notifications-dropdown');
    }

    public function reply(int $eventId, bool $reply)
    {
        $event = Event::find($eventId);
        if ($event) {
            $reponse = InvitationService::replyPhotographertInvitation($event, auth()->user(), $reply);
            $this->dispatch('new-message', $reponse);
        }
    }
}
