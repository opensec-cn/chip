<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-05-02
 * Time: 23:01
 */

namespace Chip\Report;

use Chip\Alarm;

interface ReportInterface
{
    /**
     * add a alarm for report
     *
     * @param Alarm $alarm
     * @return mixed
     */
    public function feed(string $filename, string $code, Alarm $alarm);

    /**
     * show report to user
     * @return mixed
     */
    public function render();

    /**
     * add a context variable to context
     * @return mixed
     */
    public function assign($key, $value);
}
