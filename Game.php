<?php

namespace Bowling;
require_once('GameInterface.php');
class Game implements GameInterface
{
    private $score;
    private $pins=0;

    public function __construct($score, $pins)
    {
        $this->score = $score;
        $this->pins = $pins;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function roll()
    {
        fscanf(STDIN, "%d\n", $pins);
        return $pins;
    }

    public function checkBonuses(Game $newGame, bool $strikeBonus, bool $spareBonus, $pins) : array
        {
            if ($strikeBonus) {
                $newGame->setScore($newGame->getScore() + ($pins)*2);
                $strikeBonus = false;
            } elseif ($spareBonus) {
                $newGame->setScore($newGame->getScore() + ($pins)*2);
                $spareBonus = false;
                $strikeBonus = true;
            } else {
                $newGame->setScore($newGame->getScore() + $pins);
                $strikeBonus = true;
                /*strike bonus*/
            }
            return array($spareBonus, $strikeBonus);
        }



}
