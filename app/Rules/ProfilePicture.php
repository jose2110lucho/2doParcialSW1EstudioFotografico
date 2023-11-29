<?php

namespace App\Rules;

use App\Services\RekognitionService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfilePicture implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rkService = new RekognitionService();
        $detectFaces = $rkService->detectFaces($value->get());
        if ($detectFaces['Status'] == 'success') {
            if (count($detectFaces['FaceDetails']) == 0) {
                $fail('No se detectó ningun rostro en la imagen');
            } elseif (count($detectFaces['FaceDetails']) > 1) {
                $fail('La imagen solo debe contener un rostro');
            }
        } else {
            $fail($detectFaces['ErrorMessage']);
        }
    }
}
