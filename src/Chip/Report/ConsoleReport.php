<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-05-02
 * Time: 18:36
 */

namespace Chip\Report;

use Chip\Alarm;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleReport implements ReportInterface
{
    /**
     * @var OutputInterface $output
     */
    protected $output;

    /**
     * @var $context
     */
    protected $context = [];

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function feed(string $filename, string $code, Alarm $alarm)
    {
        $ctx = $alarm->formatOutput($code);
        $level = $ctx['level'];
        $message = $ctx['message'];
        $lines = $ctx['lines'];

        $this->output->writeln([
            "",
            "==========",
            "<bg=red;fg=white>\n{$level}:{$filename}\n{$message}</>",
            "",
        ]);

        foreach ($lines as $line) {
            list($number, $line, $highlight) = $line;
            if ($highlight) {
                $this->output->writeln("<fg=red;options=bold>{$number}:{$line}</>");
            } else {
                $this->output->writeln("{$number}:{$line}");
            }
        }
    }

    public function render()
    {
        // do nothing
    }

    public function assign($key, $value)
    {
        $this->context[$key] = $value;
    }
}
