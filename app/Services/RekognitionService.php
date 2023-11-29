<?php

namespace App\Services;

use App\Models\Picture;
use App\Models\Profile_photo;
use Intervention\Image\Facades\Image;
use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;
use Aws\Rekognition\RekognitionClient;

class RekognitionService
{
    public $client;

    public function __construct()
    {
        try {
            $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
            $this->client = new RekognitionClient([
                'version' => 'latest',
                'region'  => 'eu-west-1',
                'credentials' => $credentials
            ]);
        } catch (\Throwable $th) {
            $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
            $this->client = new RekognitionClient([
                'version' => 'latest',
                'region'  => 'eu-west-1',
                'credentials' => $credentials
            ]);
        }
    }

    public function getClient()
    {
        return $this->client;
    }

    public function createCollection(String $collectionId)
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al crear la collección en aws',
        ];
        try {
            $this->client->createCollection(
                [
                    'CollectionId' => $collectionId
                ],
            );

            $response = [
                'Status' => 'success',
                'Message' => 'Collección "' . $collectionId . '" creada correctamente'
            ];
        } catch (AwsException $e) {
            $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
        } catch (\Throwable $t) {
            $response = $error + ['ErrorMessage' => $t->getMessage()];
        }
        return $response;
    }

    public function deleteCollection(String $collectionId): array
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al borrar la collección en aws',
        ];

        try {
            $this->client->deleteCollection([
                'CollectionId' => $collectionId,
            ]);

            $response = [
                'Status' => 'success',
                'Message' => 'Collección "' . $collectionId . '" eliminada correctamente'
            ];
        } catch (AwsException $e) {
            $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
        } catch (\Throwable $t) {
            $response = $error + ['ErrorMessage' => $t->getMessage()];
        }

        return $response;
    }

    public function listCollections()
    {
        $collections = array();
        try {
            $collections = $this->client->listCollections([
                'MaxResults' => 20,
            ]);
        } catch (\Throwable $th) {
        }

        return $collections;
    }

    public function listFaces(String $collectionId)
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al borrar la collección en aws',
        ];

        try {
            $faces = $this->client->listFaces([
                'CollectionId' => $collectionId,
            ])['Faces'];
            $response = [
                'Status' => 'success',
                'Faces' => $faces
            ];
        } catch (AwsException $e) {
            $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
        } catch (\Throwable $t) {
            $response = $error + ['ErrorMessage' => $t->getMessage()];
        }
        return $response;
    }

    public function indexFace(String $collectionId, String $image): array
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al indexar el rostro',
        ];

        try {
            $faces = $this->client->indexFaces([
                'CollectionId' => $collectionId,
                'Image' => [
                    'Bytes' => $image,
                ],
                'MaxFaces' => 1,
            ])['FaceRecords'];


            if (!empty($faces)) {
                $response = [
                    'Status' => 'success',
                    'Message' => 'Cara indexada correctamente',
                    'FaceId' => $faces[0]['Face']['FaceId']
                ];
            } else {
                $response = $error + ['ErrorMessage' => 'No se encontró ningun rostro en la imagen'];
            }
        } catch (AwsException $e) {
            $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
        } catch (\Throwable $t) {
            $response = $error + ['ErrorMessage' => $t->getMessage()];
        }

        return $response;
    }

    public function deleteFace(String $collectionId, String $faceId): array
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al borrar el rostro',
        ];

        try {
            $deleted = $this->client->deleteFaces([
                'CollectionId' => $collectionId,
                'FaceIds' => [$faceId]
            ]);

            if (in_array($faceId, $deleted['DeletedFaces'])) {
                $response = [
                    'Status' => 'success',
                    'Message' => 'Rostro eliminado de la collección'
                ];
            } else if (in_array($faceId, $deleted['UnsuccessfulFaceDeletions'])) {
                $response = [
                    'Status' => 'error',
                    'Message' => 'No se pudo borrar el rostro de la collección'
                ];
            } else {
                $response = [
                    'Status' => 'error',
                    'Message' => 'No existe el rostro en la collección'
                ];
            }
        } catch (AwsException $e) {
            $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
        } catch (\Throwable $t) {
            $response = $error + ['ErrorMessage' => $t->getMessage()];
        }

        return $response;
    }

    public function detectFaces(string $image): array
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al detectar los rostros',
        ];

        try {
            $faces = $this->client->detectFaces([
                'Image' => [
                    'Bytes' => $image
                ]
            ])['FaceDetails'];

            $response = [
                'Status' => 'success',
                'Message' => 'Proceso de detección de rostros completado',
                'FaceDetails' => $faces,
            ];
        } catch (AwsException $e) {
            $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
        } catch (\Throwable $t) {
            $response = $error + ['ErrorMessage' => $t->getMessage()];
        }

        return $response;
    }

    public function searchFaces(string $image): array
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al buscar los rostros',
        ];
        $facesResponse = $this->detectFaces($image);

        if ($facesResponse['Status'] == 'success') {
            try {
                $matches = [];

                foreach ($facesResponse['FaceDetails'] as $key => $FaceDetail) {
                    $bbox = self::boundingboxToInterventionDimensions($image, $FaceDetail['BoundingBox']);
                    $cropped = image::make($image)->crop(
                        $bbox['Width'],
                        $bbox['Height'],
                        $bbox['Left'],
                        $bbox['Top'],
                    );
                    $imageString = $cropped->encode('jpg', 100)->__toString();
                    //$filePath = 'public/tuarchivo' . $key . '.jpg';
                    //Storage::put($filePath, $imageCroped);

                    $matches[] = $this->client->searchFacesByImage([
                        'CollectionId' => 'users',
                        'Image' => [
                            'Bytes' => $imageString,
                        ],
                        'MaxFaces' => 1,
                        'QualityFilter' => 'AUTO',
                    ]);
                }
                $matchesCleaned = [];
                foreach ($matches as $match) {
                    $faceMatches = $match['FaceMatches'];
                    if (!empty($faceMatches)) {
                        $matchesCleaned[] = $faceMatches[0];
                    }
                }

                $response = [
                    'Status' => 'success',
                    'Message' => 'Busqueda completada',
                    'Matches' => $matchesCleaned,
                ];
            } catch (AwsException $e) {
                $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
            } catch (\Throwable $t) {
                $response = $error + ['ErrorMessage' => $t->getMessage()];
            }
        } else {
            $response = $facesResponse;
        }

        return $response;
    }

    public function searchFaceUsersByImage(string $image): array
    {
        $response = array();
        $error = [
            'Status' => 'error',
            'Message' => 'Ocurrió un error al buscar buscar los usuarios',
        ];

        $searchFaces = $this->searchFaces($image);
        try {
            if ($searchFaces['Status'] == 'success') {
                $faceIds = array();
                foreach ($searchFaces['Matches'] as $key => $match) {
                    $faceIds[] = $match['Face']['FaceId'];
                }

                $response = [
                    'Status' => 'success',
                    'Message' => 'Busqueda completada',
                    'FaceIds' => $faceIds
                ];
            } else {
                $response = $searchFaces;
            }
        } catch (AwsException $e) {
            $response = $error + ['ErrorMessage' => $e->getAwsErrorMessage()];
        } catch (\Throwable $t) {
            $response = $error + ['ErrorMessage' => $t->getMessage()];
        }
        return $response;
    }

    public function relateFaceUsersToPicture(array $faceIds, Picture $picture)
    {
        $guestIds = $picture->event->guests->pluck(['id']);
        $profilePhotos = Profile_photo::all()->whereIn('face_id', $faceIds)->whereIn('user_id', $guestIds);
        foreach ($profilePhotos as $profilePhoto) {
            $profilePhoto->user->picturesWhereIAppear()->save($picture);
        }
    }

    private static function boundingboxToInterventionDimensions(string $image, array $boundingbox): array
    {
        list($width, $height) = getimagesizefromstring($image);
        $boundingbox['Width'] = (int)($boundingbox['Width'] * $width);
        $boundingbox['Height'] = (int)($boundingbox['Height'] * $height);
        $boundingbox['Left'] = (int)($boundingbox['Left'] * $width);
        $boundingbox['Top'] = (int)($boundingbox['Top'] * $height);

        return $boundingbox;
    }
}
