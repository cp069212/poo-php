<?php 

namespace {
    use App\MatchMaker\Lobby;
    use App\Player\Player;
    use App\Player\BlitzPlayer;

    require_once('App/Player/Player.php');
    require_once('App/MatchMaker');

    $greg = new BlitzPlayer('greg');
    $jade = new BlitzPlayer('jade');

    $lobby = new Lobby();
    $lobby->addPlayers($greg, $jade);

    var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

    exit(0);
}