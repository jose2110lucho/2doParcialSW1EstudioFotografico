<?php

namespace App\Services;

use App\Mail\GuestInvitationMail;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Firebase\JWT\JWT;

class InvitationService
{
    public static function createGuestInvitation(Event $event, string $email_receiver): array
    {
        $response = [
            'status' => 'success',
            'message' => 'Invitación enviada correctamente'
        ];

        if ($event) {
            try {
                $mailData = [
                    'title' => 'Invitacion al evento ' . $event->name,
                    'event_name' => $event->name,
                    'sender_name' => $event->planner->name,
                    'start_date' => $event->start_date,
                    'start_time' => $event->start_time,
                    'address' => $event->address,
                ];
                $invitation = $event->guestInvitations->where('email_receiver', $email_receiver)->first();
        
                if ($invitation) {
                    $urlShowInvitation = route('guests.invitations.show', encrypt($invitation->id));
                    $mailData = ['url' => $urlShowInvitation] + $mailData;
                    $dateDiff = Carbon::now()->diffInHours(Carbon::parse($invitation->send_date));

                    if ($dateDiff <= 0) {
                        $response = ['status' => 'error', 'message' => 'No puede enviar otra invitación a ese correo. Espere una hora para volver a invitar dicho correo'];
                    } else {
                        Mail::to($email_receiver)->send(new GuestInvitationMail($mailData));
                        $invitation->update(['send_date' => now()]);
                    }
                } else {
                    $invitation = new Invitation([
                        'email_receiver' => $email_receiver,
                        'send_date' => now(),
                    ]);

                    $event->guestInvitations()->save($invitation);
                    $urlShowInvitation = route('guests.invitations.show', encrypt($invitation->id));
                    $mailData = ['url' => $urlShowInvitation] + $mailData;
                    Mail::to($email_receiver)->send(new GuestInvitationMail($mailData));
                }
            } catch (\Throwable $th) {
                $response = ['status' => 'error', 'message' => 'Ocurrió un error durante el envio de la invitación ' . $th->getMessage()];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No se encontró el evento'
            ];
        }
        return $response;
    }

    public static function createPhotographerInvitation(Event $event, User $photographer): array
    {
        $response = [
            'status' => 'success',
            'message' => 'Invitación enviada correctamente'
        ];
        if ($event && $photographer) {
            $invited = $event->photographersInvited->firstWhere('id', $photographer->id);
            if ($invited) {
                $event->photographersInvited()->updateExistingPivot($invited, [
                    'status' => 0,
                    'updated_at' => now(),
                ]);
            } else {
                $event->photographersInvited()->attach($photographer, ['status' => 0]);
            }
        }

        return $response;
    }

    /**
     * 
     */
    public static function replyPhotographertInvitation(Event $event, User $photographer, bool $reply): array
    {
        $response = [
            'status' => 'success',
            'message' => $reply ? 'Invitación aceptada' : 'Invitación rechazada'
        ];
        try {
            $event->photographersInvited()->updateExistingPivot($photographer, [
                'status' => $reply ? 1 : 2,
                'token' => $reply ? self::getToken($event, $photographer): null,
            ]);
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => 'Error al' . $reply ? 'aceptar' : 'rechazar' . ' la invitación'
            ];
        }
        return $response;
    }

    /**
     * 
     */
    public static function replyGuestInvitation(String $encryptInvitationId, bool $reply): array
    {
        try {
            $check = self::checkGuestInvitation($encryptInvitationId);
            if ($check['status'] == 'success') {
                $invitation = Invitation::find(decrypt($encryptInvitationId));
                $guest = User::find(Auth::id());
                if ($reply) {
                    $guest->guestEvents()->attach($invitation->event, ['token' => self::getToken($invitation->event, $guest)]);
                }
                $invitation->status = $reply ? 1 : 2;

                $invitation->save();
                $response = [
                    'status' => 'success',
                    'message' => $reply ? 'Invitación aceptada' : 'Invitación rechazada',
                    'invitation' => [
                        'id' => encrypt($invitation->id),
                        'event_name' => $invitation->event->name,
                        'status' => $invitation->status
                    ]
                ];
            } else {
                $response = $check;
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => 'Error al' . $reply ? 'aceptar' : 'rechazar' . ' la invitación. ' . $th->getMessage()
            ];
        }
        return $response;
    }

    /**
     * 
     */
    public static function checkGuestInvitation(String $encryptInvitationId): array
    {
        try {
            $invitation = Invitation::find(decrypt($encryptInvitationId));
            $guest = User::find(Auth::id());
            $photographerIds = $invitation->event->photographers->pluck(['id']);
            $plannerId = $invitation->event->planner->id;

            if ($plannerId == $guest->id) {
                $response = [
                    'status' => 'error',
                    'message' => 'No puedes responder esta invitación. Eres el organizador del evento'
                ];
            } elseif (in_array($guest->id, $photographerIds->toArray())) {
                $response = [
                    'status' => 'error',
                    'message' => 'No puedes responder esta invitación. Ya formas parte del evento como fotógrafo',
                ];
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Revisión completada',
                    'invitation' => [
                        'id' => $encryptInvitationId,
                        'event_name' => $invitation->event->name,
                        'status' => $invitation->status
                    ]
                ];
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
        return $response;
    }

    private static function getToken(Event $event, User $user) {
        $key = $event->key_event;
        $payload = [
            'user_id' => $user->id,
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
}
