<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-15
 * Time: 11:40
 */

namespace Chip;

use Symfony\Component\Finder\Finder;

class ChipFactory
{
    public function create()
    {
        return $this->createFromDir(__DIR__ . '/Visitor');
    }

    public function createFromDir(string $dir)
    {
        $chipManager = new ChipManager;

        $finder = new Finder();
        $finder->files()->in($dir)->name('*.php');
        foreach ($finder as $file) {
            $class_name = $file->getBasename('.php');
            $chipManager->addVisitor('Chip\Visitor\\' . $class_name);
        }

        return $chipManager;
    }
}
