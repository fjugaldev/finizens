<?php

namespace App\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('finizens:parse-log')
            ->setDescription('Parse the log of a communication made for a given phone number')
            ->addArgument('phone', InputArgument::REQUIRED, 'Phone number for parsing contacts
            and communications log');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $phone = $input->getArgument('phone');
            $logFileName = preg_replace('/{phone}/', $phone, getenv('LOG_FILE_PATTERN'));
            $output->writeln([
                '',
                '<bg=blue>                                                            </>',
                '<bg=blue;fg=white>  PARSING COMMUNICATIONM LOG: '.$logFileName.'  </>',
                '<bg=blue>                                                            </>',
                '',
            ]);
            $logFile = getenv('LOG_SERVER_BASE_URL').$logFileName;
            $communicationLog = explode(PHP_EOL, file_get_contents($logFile));
            $output->writeln("Parsing contacts and communnications into database...".PHP_EOL.PHP_EOL);
            $parsed = $this->getContainer()->get('api.service.contacts_service')->parse($communicationLog);
            $output->writeln("<bg=green;options=bold;fg=white>Parsing data completed!</>".PHP_EOL);

        } catch (\Exception $e) {
            $output->writeln([
                '<bg=red;options=bold;fg=white>An error has occured trying to parse the log file into database model, Error:</>',
                $e->getMessage(),
            ]);
        }
    }


}