<?php

use dokuwiki\plugin\oauth\Adapter;
use dokuwiki\plugin\oauthdiscord\Discord;

/**
 * Service Implementation for oAuth Doorkeeper authentication
 */
class action_plugin_oauthdiscord extends Adapter
{
    /**
     * @inheritdoc
     */
    public function registerServiceClass()
    {
        return Discord::class;
    }

    /**
     * @inheritDoc
     */
    public function getUser()
    {
        $oauth = $this->getOAuthService();
        $data = array();

        // basic user data
        $result = json_decode($oauth->request('https://discord.com/api/users/@me'), true);
        $data['user'] = $result['username'];
        $data['name'] = $result['global_name'];

        if ($result['verified']) {
            $data['mail'] = $result['email'];
        }

        $serverId = $this->getConf('serverId');
        if ($serverId) {
            $resultGuilds = json_decode($oauth->request('https://discord.com/api/users/@me/guilds'), true);

            $foundServer = array_column($resultGuilds, null, 'id')[$serverId] ?? false;

            if (!$foundServer) {
                return;
            }
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getScopes()
    {
        return [Discord::SCOPE_IDENTIFY, Discord::SCOPE_EMAIL, Discord::SCOPE_GUILDS];
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Discord';
    }

    /**
     * @inheritDoc
     */
    public function getColor()
    {
        return '#7289da';
    }
}
