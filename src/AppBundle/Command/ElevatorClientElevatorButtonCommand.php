<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ElevatorClientElevatorButtonCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elevator:button:elevator')
            ->setDescription('Launch elevator client')
            ->addArgument('floor', InputArgument::REQUIRED, 'Floor number')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $floor = $input->getArgument('floor');

        $connect = $this->getContainer()->get('amqp.connect.input');

        $data = [
            'floor' => $floor,
            'type' => $connect::CONN_TYPE_INTERNAL,
            'time' => microtime()
        ];

        $connect->publish(json_encode($data));
    }

}
