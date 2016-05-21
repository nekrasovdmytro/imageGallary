<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 21.05.16
 * Time: 0:18
 */

namespace GalleryBundle\Command;

use GalleryBundle\SimpleImage\SimpleImage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeSmallImagesCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('images:make-small-copies')
            ->setDescription('Make small copies of your images')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $simpleImage = new SimpleImage();

        $dir = __DIR__ . '/../../../web/uploads/images';

        if ($handle = opendir($dir)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry != '.' && $entry != '..') {
                    $path = $dir . '/' . $entry;
                    $smallPath = str_replace('images', 'small_images', $path);

                    if (file_exists($smallPath))
                        continue;

                    $simpleImage->load($path);
                    $simpleImage->resizeToHeight(350);
                    $simpleImage->save($smallPath, \IMAGETYPE_JPEG, 99, 777);
                }
            }

            closedir($handle);
        }

        $output->writeln("Done!");
    }
}