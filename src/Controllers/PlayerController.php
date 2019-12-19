<?php

namespace B3none\League\Controllers;

use B3none\League\Helpers\ExceptionHelper;
use B3none\League\Helpers\PlayerHelper;
use Exception;

class PlayerController extends BaseController
{
    /**
     * @var PlayerHelper
     */
    protected $playerHelper;

    /**
     * MatchController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->playerHelper = new PlayerHelper();
    }

    /**
     * Get players.
     *
     * @param string $discordId
     * @return string
     */
    public function getPlayerByDiscordId(string $discordId): string
    {
        try {
            $player = $this->playerHelper->getPlayerByDiscordId($discordId);

            if (count($player) < 1 || !$player['steam']) {
                $player = [
                    'error' => 'not_found'
                ];
            } elseif (!$player['score']) {
                $player['score'] = 1000;
            } else {
                $player['score'] = (int)$player['score'];
            }

            $player['in_match'] = $this->playerHelper->isInMatch($player['steam']);

            return json_encode(
                $player
            );
        } catch (Exception $exception) {
            ExceptionHelper::handle($exception);
        }
    }
}
