<?php

namespace Seeklive;

class SeekliveClient {

	const appUrl = 'https://app.seeklive.io';
	const apiUrl = 'https://seekliveapi.seekube.net';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->request = new Request($apiKey, self::apiUrl);
    }

    public static function getAppUrl()
    {
	    return self::appUrl;
    }

	public static function getApiUrl()
	{
		return self::apiUrl;
	}

    public function createConference($attributes)
    {
        return $this->request->createConference($attributes);
    }
    
    public function updateConference($conferenceId, $attributes)
    {
        return $this->request->updateParticipant($conferenceId, $attributes);
    }

    public function createParticipant($conferenceId, $attributes)
    {
        return $this->request->createParticipant($conferenceId, $attributes);
    }

    public function updateParticipant($token, $attributes)
    {
        return $this->request->updateParticipant($token, $attributes);
    }

    public function deleteParticipant($token)
    {
        return $this->request->deleteParticipant($token);
    }
}
