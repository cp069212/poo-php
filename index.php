<?php

class Player
{
    public $level;

    public function __construct(int $level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel(int $newLevel)
    {
        $this->level = $newLevel;
    }
}


class Encounter
{
    const RESULT_WINNER = 1;
    const RESULT_LOSER = -1;
    const RESULT_DRAW = 0;
    const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];

    public static function probabilityAgainst(int $levelPlayerOne, int $againstLevelPlayerTwo)
    {
        return 1/(1+(10 ** (($againstLevelPlayerTwo - $levelPlayerOne)/400)));
    }

    public static function setNewLevel(int &$levelPlayerOne, int $againstLevelPlayerTwo, int $playerOneResult)
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $levelPlayerOne += (int) (32 * ($playerOneResult - self::probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo)));
    }
}


$greg = new Player(400);
$jade = new Player(800);

$encounter = new Encounter;

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    Encounter::probabilityAgainst($greg->level, $jade->level)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
$encounter::setNewLevel($greg->level, $jade->level, Encounter::RESULT_WINNER);
$encounter::setNewLevel($jade->level, $greg->level, Encounter::RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg->level,
    $jade->level
);

exit(0);
