<?php

namespace Unit\Blackjack;

use Blackjack\Card;
use Blackjack\Hand;
use Blackjack\HandCalculator;
use Mockery as m;
use Tests\Unit\UnitTest;

/**
 * @method HandCalculator uut()
 */
class HandCalculatorTest extends UnitTest
{
    protected $uut;

    public function setUp()
    {
        parent::setUp();
    }

    protected function createUnitUnderTest()
    {
        return new HandCalculator();
    }
    
    public function testCanCalculateScoreForSimpleHand()
    {
        $hand = new Hand();
        $hand->add(new Card(Card::SUIT_HEARTS, 2));
        $hand->add(new Card(Card::SUIT_HEARTS, 5));
        
        $this->uut()->calculate($hand);
        
        $this->verifyThat($hand->getBestScore(), equalTo(7));
        $this->verifyThat($hand->hasAlternateScore(), is(false));
    }

    public function testCanCalculateScoreForHandContainingAnAce()
    {
        $hand = new Hand();
        $hand->add(new Card(Card::SUIT_HEARTS, Card::RANK_ACE));
        $hand->add(new Card(Card::SUIT_HEARTS, Card::RANK_ACE));
        $hand->add(new Card(Card::SUIT_HEARTS, 5));

        $this->uut()->calculate($hand);

        $this->verifyThat($hand->getBestScore(), equalTo(17));
        $this->verifyThat($hand->getAlternativeScore(), equalTo(7));
    }

    public function testCanCalculateABlackJack()
    {
        $hand = new Hand();
        $hand->add(new Card(Card::SUIT_HEARTS, Card::RANK_KING));
        $hand->add(new Card(Card::SUIT_HEARTS, Card::RANK_ACE));

        $this->uut()->calculate($hand);

        $this->verifyThat($hand->getBestScore(), equalTo(21));
    }
}
