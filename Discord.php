<?php

namespace dokuwiki\plugin\oauthdiscord;

use dokuwiki\plugin\oauth\Service\AbstractOAuth2Base;
use OAuth\Common\Http\Uri\Uri;

/**
 * Custom Service for Discord oAuth
 */
class Discord extends AbstractOAuth2Base
{
    // Discord scopes
    const SCOPE_EMAIL = 'email';
    const SCOPE_IDENTIFY = 'identify';

    /**
     * @inheritdoc
     */
    public function getAuthorizationEndpoint()
    {
        return new Uri('https://discord.com/oauth2/authorize');
    }

    /**
     * @inheritdoc
     */
    public function getAccessTokenEndpoint()
    {
        return new Uri('https://discord.com/api/oauth2/token');
    }

    /**
     * @inheritdoc
     */
    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
    }
}
