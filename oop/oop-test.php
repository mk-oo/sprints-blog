<?php
abstract class Piece
{
    /*
    INSTEAD OF VAR (public), you can use public, private, protected */
    protected $type;
    public $x;
    protected $y;
    protected $team;
    function  __construct($type, $x, $y, $team)
    {
        $this->type = $type;
        $this->x = $x;
        $this->y = $y;
        $this->team = $team;
    }
    function echoCoordinates()
    {
        echo $this->x, $this->y;
    }
    function echoTeamColor()
    {
        echo $this->team->color;
    }
}

class Team
{
    public $color;
    function __construct($color)
    {
        $this->color = $color;
    }
}

class Pawn extends Piece
{
    function __construct($x, $y, $team)
    {
        parent::__construct('pawn', $x, $y, $team);
    }

    static function staticFunc($i)
    {
        echo $i + 1;
    }

    function __destruct()
    {
        echo 'Destruct';
    }
}

$pawn  = new Pawn(1, 2, new Team('white'));
$pawn->echoCoordinates();
echo $pawn->x;
echo '<br />';
$pawn->echoTeamColor();
echo '<br />';
Pawn::staticFunc(5);
