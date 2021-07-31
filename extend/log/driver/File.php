<?php

namespace log\driver;

use think\log\driver\File as FileDriver;

/**
 * runtime/log 按 Ymd 记录
 */
class File extends FileDriver
{

    /**
     * 获取主日志文件名
     * @access public
     * @return string
     */
    protected function getMasterLogFile()
    {
        if ($this->config['single']) {
            $name = is_string($this->config['single']) ? $this->config['single'] : 'single';

            $destination = $this->config['path'] . $name . '.log';
        } else {
            $cli = PHP_SAPI == 'cli' ? '_cli' : '';

            if ($this->config['max_files']) {
                $filename = date('Ymd') . $cli . '.log';
                $files    = glob($this->config['path'] . '*.log');

                try {
                    if (count($files) > $this->config['max_files']) {
                        unlink($files[0]);
                    }
                } catch (\Exception $e) {
                }
            } else {
                $filename = date('Ymd') . DIRECTORY_SEPARATOR . date('d') . $cli . '.log';
            }

            $destination = $this->config['path'] . $filename;
        }

        return $destination;
    }
}
