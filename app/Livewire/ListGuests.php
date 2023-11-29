<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\InvitationService;
use Livewire\Component;


class ListGuests extends Component
{
    private $titlePage = 'Lista de invitados';
    public $event, $invitations, $emailReceiver;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->getGuestInvitations();
    }

    public function render()
    {
        $this->invitations = $this->invitations->sortByDesc('send_date');
        return view('livewire.list-guests')->title($this->titlePage);
    }

    private function getGuestInvitations()
    {
        $this->invitations = $this->event->guestInvitations;
    }

    public function send()
    {
        $this->validate([
            'emailReceiver' => 'required | email:rfc,dns',
        ]);
        $sendResponse = InvitationService::createGuestInvitation($this->event, $this->emailReceiver);
        if ($sendResponse['status'] == 'success') {
            $this->invitations = $this->event->guestInvitations;
        }
        $this->dispatch('new-message', $sendResponse);
    }
}
