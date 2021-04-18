<?php

namespace App;

class Logger
{
    CONST PATH = __DIR__ . '../../logs';
    CONST NAME = 'iban_app';

    protected static array $loggers = array();

    protected ?string $file;
    protected $fp;

    /**
     * Logger constructor.
     * @param string|null $file
     */
    public function __construct(string $file = null)
    {
        $this->file = $file;

        $this->fp = fopen($this->file == null ? self::PATH . '/' . self::NAME . '.log' : self::PATH . '/' . $this->file, 'a+');
    }

    /**
     * @return void
     */
    public function open()
    {
        $this->fp = fopen($this->file == null ? self::PATH . '/' . self::NAME . '.log' : self::PATH . '/' . $this->file, 'a+');
    }

    /**
     * @param string|null $file
     * @return $this
     */
    public static function getLogger(?string $file = null): Logger
    {
        if (!isset(self::$loggers[self::NAME ])) {
            self::$loggers[self::NAME ] = new Logger($file);
        }

        return self::$loggers[self::NAME ];
    }

    /**
     * @param string $message
     * @return void
     */
    public function log(string $message)
    {
        if (!is_string($message)) {
            $this->logPrint($message);

            return;
        }

        $log = '[' . date('D M d H:i:s Y', time()) . '] ';
        if (func_num_args() > 1) {
            $params = func_get_args();

            $message = call_user_func_array('sprintf', $params);
        }

        $log .= $message;
        $log .= PHP_EOL;

        $this->write($log);
    }

    /**
     * @param $obj
     */
    public function logPrint($obj)
    {
        ob_start();

        print_r($obj);

        $ob = ob_get_clean();
        $this->log($ob);
    }

    /**
     * @param  $string
     */
    protected function write( $string)
    {
        fwrite($this->fp, $string);

        echo $string;
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        fclose($this->fp);
    }
}