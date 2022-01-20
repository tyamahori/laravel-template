<?php

namespace Package\Gemba;

use Illuminate\Console\Command;
use Package\Gemba\Enum\PaymentState;
use Package\Gemba\Polymorphism\FeeFactory;
use Package\Gemba\Polymorphism\FeeType;
use Package\Gemba\Polymorphism\Reservation;

class ReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'command:reserve';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle(): void
    {
        $feesByFactory = [
            FeeFactory::byType('child'),
            FeeFactory::byType('adult'),
            FeeFactory::byType('adult'),
            FeeFactory::byType('adult'),
        ];

        $feesFeeType = [
            FeeType::CHILD->fee(),
            FeeType::ADULT->fee()
        ];

        $finalReservation = (new Reservation($feesByFactory))
            ->add(FeeType::CHILD->fee())
            ->add(FeeType::ADULT->fee());

        $state = PaymentState::ACCEPTED
            ->proceed(PaymentState::PAID)
            ->proceed(PaymentState::WAITING);

        $nextState = $state->proceed(PaymentState::PAID);

        dd($nextState, $feesByFactory, $feesFeeType, $finalReservation, $finalReservation->totalYen(), PaymentState::allStatus());
    }
}
