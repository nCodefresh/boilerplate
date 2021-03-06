<?php

namespace Blackjack;

class Dealer extends Player
{
    const DEALER_MAXIMUM_SCORE = 17;

    /**
     * @var Deck
     */
    private $deck;

    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
        parent::__construct();
    }

    public function drawMany(int $count): Hand
    {
        for ($i = 0; $i < $count; ++$i) {
            $this->draw();
        }

        return $this->getHand();
    }

    public function draw()
    {
        $this->hit($this);
    }

    public function hit(Player $player, int $count = 1)
    {
        for ($i = 0; $i < $count; ++$i) {
            $player->receiveCard($this->deck->draw());
        }
    }

    public function play(HandCalculator $handCalculator)
    {
        while ($this->hasToDraw()) {
            $this->draw();
            $this->calculateHand($handCalculator);
        }
    }

    public function hasToDraw(): bool
    {
        return $this->getBestScore() < static::DEALER_MAXIMUM_SCORE;
    }
}
