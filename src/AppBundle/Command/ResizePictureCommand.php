<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

class ResizePictureCommand extends ContainerAwareCommand
{
    const DEFAULT_SIZE_IMAGE = 200 ;
    const DEFAULT_INPUT_FOLDER = 'web/uploads/' ;
    const DEFAULT_OUTPUT_FOLDER = 'web/uploads/resize/' ;

    protected function configure()
    {
        $this
            ->setName('resize:picture')
            ->setDescription('Resize picture')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Image folder path'
            )
            ->addOption(
                'size',
                null,
                InputOption::VALUE_OPTIONAL,
                'Size new picture (default 200 pixels)'
            )
            ->addOption(
                'out',
                'o',
                InputOption::VALUE_OPTIONAL,
                'Folder output'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Log service
        $logger = $this->getContainer()->get('logger');

        $path = self::DEFAULT_INPUT_FOLDER . $input->getArgument('path');
        $size = $input->getOption('size') ? $input->getOption('size') : self::DEFAULT_SIZE_IMAGE ;
        $out = $input->getOption('out') ? $input->getOption('out') : self::DEFAULT_OUTPUT_FOLDER ;

        if ( file_exists( $path ) ) {
            $imagine = new \Imagine\Gd\Imagine();
            $image = $imagine->open($path);
            $box = new \Imagine\Image\Box($size, $size);
            $filename = basename($path);

            $image->resize($box)->save($out . $filename);
            $output->writeln(sprintf('Path: %s - Folder output: %s', $path, $out));
            // write a log
            $logger->info(sprintf('Path: %s - Folder output: %s', $path, $out));
        }
        else {
            $output->writeln('<info>File not found </info>');
            // write a log
            $logger->warning('File not found');
        }
    }
}