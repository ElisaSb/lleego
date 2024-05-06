<?php

declare(strict_types=1);

namespace App\Command\Segment;

use App\Service\Segment\SegmentService;
use JMS\Serializer\Serializer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function PHPUnit\Framework\isFalse;

class FlightSegmentListCommand extends Command
{
    private SegmentService $segmentService;

    public function __construct(SegmentService $segmentService)
    {
        $this->segmentService = $segmentService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('lleego:avail')
            ->setDescription('List availability flights')
            ->setHelp('example: php bin/console llego:avail MAD BIO 2023-06-01')
            ->addArgument('origin',InputArgument::REQUIRED, 'Origin param is required.')
            ->addArgument('destination',InputArgument::REQUIRED, 'Destination param is required.')
            ->addArgument('date', InputArgument::REQUIRED, 'Date param is required.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);
        $table->setHeaders($this->getTableHeaders());

        $response = $this->segmentService->read(
            $input->getArgument('origin'),
            $input->getArgument('destination'),
            $input->getArgument('date')
        );

        if (key_exists('message', $response)) {
            $table->render();

            $output->writeln('');
            $output->writeln($response['message']);
            $output->writeln('');

            return Command::FAILURE;
        }

        $table->setRows($response);
        $table->render();

        return Command::SUCCESS;
    }

    private function getTableHeaders(): array
    {
        return [
            'Origin Code',
            'Origin Name',
            'Destination Code',
            'Destination Name',
            'Start',
            'End',
            'Transport Number',
            'Company Code',
            'Company Name'
        ];
    }
}