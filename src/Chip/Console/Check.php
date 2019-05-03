<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/4/23
 * Time: 2:15
 */

namespace Chip\Console;

use Chip\Alarm;
use Chip\AlarmLevel;
use Chip\ChipFactory;
use Chip\Report\ConsoleReport;
use Chip\Report\HTMLReport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class Check extends Command
{
    protected static $defaultName = 'check';

    protected $chip = null;

    protected $level = ['info', 'warning', 'danger', 'critical'];

    public function __construct(?string $name = null)
    {
        parent::__construct($name);
        $this->chip = (new ChipFactory)->create();
    }

    protected function configure()
    {
        $this->setDescription('Check a file or directory.')->setHelp('This command allows you to detect potential security threat in a file or directory.');
        $this->addArgument("file", InputArgument::REQUIRED, "filename or directory path");
        $this->addOption(
            "level",
            '-l',
            InputOption::VALUE_OPTIONAL,
            'Display message above this level, choice is [' . implode(', ', $this->level) . ']',
            'warning'
        );
        $this->addOption(
            'report',
            '-r',
            InputOption::VALUE_OPTIONAL,
            'Output data format, choice is [console, html]',
            'console'
        );
        $this->addOption(
            'output',
            '-o',
            InputOption::VALUE_OPTIONAL,
            'Write the report to the specified file path'
        );
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $level = $input->getOption('level');
        if (!in_array($level, $this->level, true)) {
            throw new RuntimeException('level must be one of [' . implode(', ', $this->level) . ' ]');
        }

        $report = $input->getOption('report');
        if (!in_array($report, ['console', 'html'])) {
            throw new \RuntimeException('report must be one of [console, html]');
        }

        $outputPath = $input->getOption('output');
        if ($report == 'html' && empty($outputPath)) {
            throw new \RuntimeException('Ouput path cannot be empty');
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Chip\Exception\FormatException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        switch ($input->getOption('report')) {
            case 'html':
                $report = new HTMLReport($input->getOption('output'));
                break;
            case 'console':
            default:
                $report = new ConsoleReport($output);
                break;
        }
        $report->assign('commandLine', 'chip.phar ' . strval($input));
        $report->assign('startTime', date('Y-m-d H:i:s'));

        $file = $input->getArgument("file");
        $finder = new Finder();

        if (is_dir($file)) {
            $finder->files()->in($file)->name("*.php");
        } elseif (is_file($file)) {
            $finder->files()->in(realpath(dirname($file)))->name(basename($file));
        } else {
            throw new RuntimeException("file ${file} doesn't exists");
        }

        $level = strtoupper($input->getOption('level'));
        $filesCount = 0;
        foreach ($finder as $fileobj) {
            $filesCount++;
            $content = $fileobj->getContents();
            foreach ($this->checkCode($content) as $alarm) {
                if ($alarm->getLevel()->getValue() >= AlarmLevel::$level()->getValue()) {
                    $report->feed($fileobj->getPathname(), $content, $alarm);
                }
            }
        }

        $report->assign('filesCount', $filesCount);
        $report->assign('endTime', date('Y-m-d H:i:s'));
        $report->render();
    }

    /**
     * @param string $code
     * @return \Generator
     * @throws \Chip\Exception\FormatException
     */
    protected function checkCode(string $code)
    {
        $alarms = $this->chip->detect($code);
        foreach ($alarms as $alarm) {
            yield $alarm;
        }
    }
}
