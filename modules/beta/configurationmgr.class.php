<?php
/**
 * From PHP.net sample at 
 * http://www.php.net/manual/fr/function.parse-ini-file.php#95747
 * 
 * @author Mauro Gabriel Titimoli
 * @version 1.0
 * @copyright 2010/01/19
 */
class ConfigurationMgr {
    const AUTO = 0;
    const JSON = 2;
    const PHP_INI = 4;
    const XML = 16;

    static private $CONF_EXT_RELATION = array(
        'json' => 2, // JSON
        'ini' => 4,  // PHP_INI
        'xml' => 16  // XML
    );

    static private $instances;

    private $data;

    static public function objectToArray($obj) {
        $arr = (is_object($obj))?
            get_object_vars($obj) :
            $obj;

        foreach ($arr as $key => $val) {
            $arr[$key] = ((is_array($val)) || (is_object($val)))?
                self::objectToArray($val) :
                $val;
        }

        return $arr;
    }

    private function __construct($file, $type = Configuration::AUTO) {
        if ($type == self::AUTO) {
            $type = self::$CONF_EXT_RELATION[pathinfo($file, PATHINFO_EXTENSION)];
        }

        switch($type) {
            case self::JSON:
                $this->data = json_decode(file_get_contents($file), true);
                break;

            case self::PHP_INI:
                $this->data = parse_ini_file($file, true);
                break;

            case self::XML:
                $this->data = self::objectToArray(simplexml_load_file($file));
                break;
        }
    }

    static public function & getInstance($file, $type = Configuration::AUTO) {
        if(! isset(self::$instances[$file])) {
            self::$instances[$file] = new Configuration($file, $type);
        }

        return self::$instances[$file];
    }

    public function __get($section) {
        if ((is_array($this->data)) &&
                (array_key_exists($section, $this->data))) {
            return $this->data[$section];
        }
    }

    public function getAvailableSections() {
        return array_keys($this->data);
    }
}

$configuration = Configuration::getInstance(/*configuration filename*/);
foreach($configuration->getAvailableSections() as $pos => $sectionName) {
    var_dump($sectionName);
    var_dump($configuration->{$sectionName});
}
?>