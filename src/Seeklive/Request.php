<?php

namespace Seeklive;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class Request {

    /**
     * An HTTP Client
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new Request
     * Bootlegness for testing
     * @param null $client
     */
    public function __construct($auth, $client=null)
    {
        if (!is_null($client)) {
            $this->client = $client;
            return;
        }

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8080',
            'headers' => [
                'Authorization' => $auth
            ]
        ]);
    }

    /**
     * Send Create Conference Request
     * @param $attributes
     * @return Response
     */
    public function createConference($attributes)
    {
        try {
            $response = $this->client->post('/conferences', array(
                'json' => $attributes,
            ));
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

        return new Response($response->getStatusCode(), $response->getReasonPhrase());
    }

    /**
     * Send Create Participant Request
     * @param $conferenceId
     * @param $attributes
     * @return Response
     */
    public function createParticipant($conferenceId, $attributes)
    {
        $attributes['_conference'] = $conferenceId;

        try {
            $response = $this->client->post('/participants/', array(
                'json' => $attributes,
            ));
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

        return new Response($response->getStatusCode(), $response->getBody()->getContents());
    }

    /**
     * Send Create Participant Request
     * @param $token
     * @param $attributes
     * @return Response
     */
    public function updateParticipant($token, $attributes)
    {
        try {
            $response = $this->client->patch('/participants/' . $token, array(
                'json' => $attributes,
            ));
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

        return new Response($response->getStatusCode(), $response->getBody()->getContents());
    }

    /**
     * Send Delete Participant Request
     * @param $token
     * @return Response
     */
    public function deleteParticipant($token)
    {
        try {
            $response = $this->client->delete('/participants/' . $token, array(
                'auth' => $this->auth,
            ));
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

        return new Response($response->getStatusCode(), $response->getReasonPhrase());
    }
}
