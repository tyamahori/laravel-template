<?php

namespace Package\Gemba;

use Illuminate\Console\Command;
use Package\Gemba\BuilderPattern\SampleDto;
use Package\Gemba\BuilderPattern\SampleDtoBuilder;
use Package\Gemba\Collection\Family;
use Package\Gemba\Collection\FamilyMember;
use Package\Gemba\ValueObject\PairAnnualIncome;
use Package\Gemba\ValueObject\SingleAnnualIncome;

class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'command:sample';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @param SampleDtoBuilder $sampleDtoBuilder
     * @return void
     */
    public function handle(
        SampleDtoBuilder $sampleDtoBuilder
    ): void {

        $sampleDto = $sampleDtoBuilder
            ->setFrom('from@email.com')
            ->setTo('to@email.com')
            ->setSubject('subject')
            ->setBody('body')
            ->build();


        echo $sampleDto->getSubject();

        var_dump($sampleDto->getTo());


        $familyMembers = [
            new FamilyMember('おとーちゃん', true),
            new FamilyMember('おかーちゃん', true),
            new FamilyMember('おねーちゃん'),
            new FamilyMember('おにーちゃん'),
            new FamilyMember('わいーちゃん'),
        ];

        $family = new Family($familyMembers);

        foreach ($family as $member) {
            echo $member->name();
        }

        echo "----" . PHP_EOL;

        foreach ($family->add(new FamilyMember('しらないおじちゃん')) as $member) {
            echo $member->name();
        }

        echo "----" . PHP_EOL;

        foreach ($family->filterHasIncome() as $member) {
            echo $member->name();
        }

        echo "----" . PHP_EOL;

        $singleIncome = new SingleAnnualIncome(1000);
        echo $singleIncome->value() . PHP_EOL;
        echo $singleIncome->rawAnnualIncome() . PHP_EOL;
        echo $singleIncome->annualIncomeForDisplay() . PHP_EOL;

        echo "----" . PHP_EOL;

        $addedSingleIncome = $singleIncome->add(new SingleAnnualIncome(1));
        echo $addedSingleIncome->value() . PHP_EOL;
        echo $addedSingleIncome->rawAnnualIncome() . PHP_EOL;

        echo "----" . PHP_EOL;

        $pairIncome = new PairAnnualIncome(
            new SingleAnnualIncome(1000),
            new SingleAnnualIncome(2000)
        );

        echo $pairIncome->value() . PHP_EOL;
        echo $pairIncome->rawValue() . PHP_EOL;
        echo $pairIncome->annualIncomeForView() . PHP_EOL;
    }
}
