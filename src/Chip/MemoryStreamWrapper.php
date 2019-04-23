<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/13
 * Time: 3:40
 */

namespace Chip;

// phpcs:disable PSR1.Methods.CamelCapsMethodName
class MemoryStreamWrapper
{
    const WRAPPER_NAME = 'string';

    private $_content = '';

    private $_position;

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $this->_position = 0;
        $this->_content = substr($path, strlen(self::WRAPPER_NAME) + 3);
        return true;
    }

    public function stream_read($count)
    {
        $ret = substr($this->_content, $this->_position, $count);
        $this->_position += strlen($ret);
        return $ret;
    }

    public function stream_stat()
    {
        return array();
    }

    public function stream_eof()
    {
        return $this->_position >= strlen($this->_content);
    }
}
// phpcs:enable
