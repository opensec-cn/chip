<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-05-02
 * Time: 18:36
 */

namespace Chip\Report;

use Chip\Alarm;
use Twig\TwigFunction;

class HTMLReport implements ReportInterface
{
    /**
     * @var \Twig\Environment $engine
     */
    protected $engine;

    /**
     * Output filename
     *
     * @var string
     */
    protected $outputFilename;

    /**
     * Vulnerabilities array
     * @var array $table
     */
    protected $vulTable = [];

    /**
     * @var array $context
     */
    protected $context = [];

    public function __construct($outputFilename, $debug = false)
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Templates/Default');
        $this->engine = new \Twig\Environment($loader, [
            'debug' => $debug,
            'cache' => false,
        ]);

        $callback = new TwigFunction('formatCode', [$this, 'formatCode'], ['is_safe' => ['html']]);
        $this->engine->addFunction($callback);
        $this->outputFilename = $outputFilename;
    }

    public function assign($key, $value)
    {
        $this->context[$key] = $value;
    }

    public function feed(string $filename, string $code, Alarm $alarm)
    {
        $ctx = $alarm->formatOutput($code);
        if (array_key_exists($filename, $this->vulTable)) {
            $this->vulTable[$filename][] = $ctx;
        } else {
            $this->vulTable[$filename] = [$ctx];
        }
    }

    public function render()
    {
        $vulnCount = array_reduce($this->vulTable, function ($carry, $item) {
            $carry += count($item);
            return $carry;
        }, 0);
        $this->assign('vulnCount', $vulnCount);
        $this->assign('statistics', $this->statistics());
        $this->assign('vulTable', $this->vulTable);

        $data = $this->engine->render('index.twig.html', $this->context);
        file_put_contents($this->outputFilename, $data);
    }

    protected function statistics()
    {
        $statistics = [];
        foreach ($this->vulTable as $filename => $vuls) {
            $statistics[$filename] = ['info' => 0, 'warning' => 0, 'danger' => 0, 'critical' => 0];
            foreach ($vuls as $vul) {
                $statistics[$filename][$vul['level']]++;
            }
        }
        return $statistics;
    }

    public function formatCode($vuln)
    {
        $lines = array_map(function ($line) {
            $code = htmlspecialchars($line[1], ENT_HTML401 | ENT_QUOTES, 'ISO-8859-1');
            if ($line[2]) {
                return "<span class='highlight'>{$line[0]}:{$code}</span>";
            } else {
                return "{$line[0]}:{$code}";
            }
        }, $vuln['lines']);

        return implode("\n", $lines);
    }

    public function formatLevel($level)
    {
        $sw = [
            'critical' => 'danger',
            'danger'   => '',
        ];
    }
}
