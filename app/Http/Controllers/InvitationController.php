<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Http\Requests\UpdateInvitationRequest;
use App\Mail\GuestInvitationMail;
use App\Models\Event;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showGuestInvitation(String $invitationId)
    {
        $response = InvitationService::checkGuestInvitation($invitationId);
        return view('invitations.show_guest_invitation', compact('response'));
    }

    /**
     *
     */
    public function rejectGuestInvitation(String $invitationId)
    {
        $response = InvitationService::replyGuestInvitation($invitationId, false);
        return view('invitations.show_guest_invitation', compact('response'));
    }

    /**
     *
     */
    public function acceptGuestInvitation(String $invitationId)
    {
        $response = InvitationService::replyGuestInvitation($invitationId, true);
        return view('invitations.show_guest_invitation', compact('response'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvitationRequest $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invitation $invitation)
    {
        //
    }
}
