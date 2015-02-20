<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;



class ResizeImagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('resize:images:all')
            ->setDescription('Resize images');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog') ;

        $size = $dialog->ask($output, 'Size picture (200): ', '200');

        $out = $dialog->ask($output, 'Output folder: ');

        $command = $this->getApplication()->find('resize:picture');

        $arguments = array(
            'command' => 'resize:picture',
            '--size'  => $size,
            '--out'   => $out
        );


        $em = $this->getContainer()->get('doctrine');

        $images = $em->getRepository('SatoMoviesBundle:Image')->findAll() ;

        $progress = $this->getHelperSet()->get('progress');
        $progress->start( $output , count($images) ) ;


        foreach( $images as $image ) {
            $path = $image->getPath() ;
            if ( empty( $path ) ) {
                $output->writeln('<info>File is empty </info>');
                $progress->advance();
                continue ;
            }

            $arguments['path'] = $image->getPath();

            $input = new ArrayInput($arguments);

            $command->run( $input , $output );

            $progress->advance();
        }
    }
}