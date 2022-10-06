<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\CoinsCreateService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// TODO: change name to update command
/**
 * Class SaveCoinsCommand
 */
#[AsCommand(
    name: 'coins:save',
    description:'Saves coins list to DB'
)]
class SaveCoinsCommand extends Command
{

    /** @var $coinsCreateService */
    private $coinsCreateService;

    /**
     * @param CoinsCreateService $coinsCreateService
     */
    public function __construct(CoinsCreateService $coinsCreateService)
    {
        parent::__construct();
        $this->coinsCreateService = $coinsCreateService;
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('coins:save')
        ->setDescription('Saves coins list to DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->coinsCreateService->create($output);

        return Command::SUCCESS;
    }
}