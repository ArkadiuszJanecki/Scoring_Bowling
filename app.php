<?php

namespace Bowling;
require_once('Game.php');

    $newGame = new Game(0,0);
    $pins_first=0;
    $pins_second=0;
    $spareBonus=false;
    $strikeBonus=false;

    for ($frame = 1; $frame <= 10; $frame++)
    {
        if($frame == 10) /*last round*/
        {
            fwrite(STDOUT, 'Last Round!'."\n");
            fwrite(STDOUT, 'First Shot Pins hit:');

            $pins_first = $newGame->roll();

            if($pins_first > 10 || !is_numeric($pins_first)) /*wrong input*/
            {
                fwrite(STDOUT, 'Wrong input ');
                break;
            }
            elseif($pins_first == 10) /*1st shot strike*/
            {
                $bonusArray = $newGame->checkBonuses($newGame,$strikeBonus,$spareBonus,$pins_first);
                $spareBonus = $bonusArray[0];
                $strikeBonus = true;

                fwrite(STDOUT, 'Second Shot Pins hit:');
                $pins_second = $newGame->roll();

                if($pins_second > 10 || !is_numeric($pins_second))
                {
                    fwrite(STDOUT, 'Wrong input ');
                    break;
                }
                elseif($pins_second == 10)/*2nd shot strike*/
                {
                    $bonusArray = $newGame->checkBonuses($newGame,$strikeBonus,$spareBonus,$pins_second);
                    $spareBonus = $bonusArray[0];
                    $strikeBonus = true;

                    $pins_third = $newGame->roll();

                    if($pins_third > 10 || !is_numeric($pins_third))
                    {
                        fwrite(STDOUT, 'Wrong input ');
                        break;
                    }else
                    {
                        if($strikeBonus || $spareBonus)
                        {
                            $newGame->setScore($newGame->getScore()+($pins_third)*2);
                        }else
                        {
                            $newGame->setScore($newGame->getScore()+$pins_third);
                        }

                    }

                }elseif($pins_second < 10)/*second shot <10*/
                    {
                        $bonusArray = $newGame->checkBonuses($newGame,$strikeBonus,$spareBonus,$pins_second);
                        $spareBonus = $bonusArray[0];
                        $strikeBonus = true;

                        fwrite(STDOUT, 'Third Shot Pins hit:');
                        $pins_third = $newGame->roll();

                        if($pins_third > 10 || !is_numeric($pins_third) || ($pins_second+$pins_third) > 10) /*3rd bonus shot*/
                        {
                            fwrite(STDOUT, 'Wrong input ');
                            break;
                        }else
                        {
                            if($strikeBonus || $spareBonus)
                            {
                                $newGame->setScore($newGame->getScore()+($pins_third*2));
                            }else
                            {
                                $newGame->setScore($newGame->getScore()+$pins_third);
                            }
                        }
                    }
            }
            elseif($pins_first < 10)/*1st shot less than 10*/
            {
                $bonusArray = $newGame->checkBonuses($newGame,$strikeBonus,$spareBonus,$pins_first);
                $spareBonus = $bonusArray[0];
                $strikeBonus = true;

                fwrite(STDOUT, 'Score: '.$newGame->getScore()."\n\n");
                fwrite(STDOUT, 'Second Shot Pins hit:');
                $pins_second = $newGame->roll();

                if(($pins_first + $pins_second)>10 || !is_numeric($pins_first))
                {
                    fwrite(STDOUT, 'Wrong input ');
                    break;
                }elseif (($pins_first + $pins_second) == 10) /* spare after 2 shot*/
                {
                    $bonusArray = $newGame->checkBonuses($newGame,$strikeBonus,$spareBonus,$pins_second);
                    $strikeBonus = $bonusArray[1];
                    $spareBonus = $bonusArray[0];

                    fwrite(STDOUT, 'Score: '.$newGame->getScore()."\n\n");
                    fwrite(STDOUT, 'By hitting spare u got extra shot!'."\n");
                    fwrite(STDOUT, 'Third Shot Pins hit:');
                    $pins_third = $newGame->roll();

                    if($pins_third > 10 || !is_numeric($pins_third))/*3rd shot*/
                    {
                        fwrite(STDOUT, 'Wrong input ');
                        break;
                    }elseif ($pins_third == 10)
                    {

                        $newGame->setScore($newGame->getScore()+10);
                    }else
                    {
                        $newGame->setScore($newGame->getScore()+$pins_third);
                        fwrite(STDOUT, 'Score: '.$newGame->getScore()."\n\n");
                        continue;
                    }
                }

                }
            fwrite(STDOUT, 'Score: '.$newGame->getScore()."\n\n");
            break;
        }

        /* 1-9 frame */
        fwrite(STDOUT, 'Frame: '.$frame."\n");
        fwrite(STDOUT, 'First Shot Pins hit:');

        $pins_first = $newGame->roll();

        if($pins_first > 10 || !is_numeric($pins_first))/*1st shot*/
        {
            fwrite(STDOUT, 'Wrong input ');
            break;
        }
        elseif($pins_first == 10)/*1st shot strike*/
        {
            $bonusArray = $newGame->checkBonuses($newGame,$strikeBonus,$spareBonus,$pins_first);
            $strikeBonus = $bonusArray[1];
            $spareBonus = $bonusArray[0];
        }
        elseif($pins_first<10)/*1st shot < 10*/
        {
            if($strikeBonus || $spareBonus)
            {
                $newGame->setScore($newGame->getScore()+($pins_first*2));
                $spareBonus = false;
            }else
            {
                $newGame->setScore($newGame->getScore()+$pins_first);
                $spareBonus = false;
            }

            fwrite(STDOUT, 'Score: '.$newGame->getScore()."\n\n");
            fwrite(STDOUT, 'Second Shot Pins hit:');
            $pins_second = $newGame->roll();

            if(($pins_first + $pins_second)>10 || !is_numeric($pins_first))
            {
                fwrite(STDOUT, 'Wrong input ');
                break;
            }elseif (($pins_first + $pins_second) == 10)/*spare*/
            {
                $newGame->setScore($newGame->getScore()+$pins_second);
                $spareBonus = true;
                /*spare bonus*/
            }else
            {
                if($strikeBonus)
                {
                    $newGame->setScore($newGame->getScore()+($pins_second * 2));
                    $strikeBonus = false;
                }elseif($spareBonus)
                {
                    $newGame->setScore($newGame->getScore() + $pins_second*2);
                    $spareBonus = false;
                }else
                {
                    $newGame->setScore($newGame->getScore()+$pins_second);
                }
            }
        }
        fwrite(STDOUT, 'Score: '.$newGame->getScore()."\n\n");
    }
    fwrite(STDOUT, 'Game over.');
    fwrite(STDOUT, 'Score: '.$newGame->getScore()."\n\n");

