<?php

namespace Aternos\Sherlock\Maps;

use Aternos\Sherlock\MappedData\MappedClass;
use Aternos\Sherlock\MappedData\MappedField;
use Aternos\Sherlock\MappedData\MappedMethod;

class YarnMap extends ObfuscationMap
{
    protected array $fields = [];
    protected array $methods = [];

    protected function parseMappings(): void
    {
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $this->content) as $line) {
            $data = str_getcsv($line, "\t", enclosure: '"', escape: "");
            $type = $data[0];

            $named = array_pop($data);
            $named = str_replace("/", ".", $named ?? "" );

            $intermediary = array_pop($data);
            $intermediary = str_replace("/", ".", $intermediary ?? "" );

            switch ($type) {
                case "CLASS":
                    $this->addClass(new MappedClass($named, $intermediary));
                    break;

                case "FIELD":
                    $this->fields[$intermediary] = new MappedField(null, $named, $intermediary);
                    break;

                case "METHOD":
                    $this->methods[$intermediary] = new MappedMethod(null, null,null, $named, $intermediary);
                    break;

                case "v1":
                case "":
                case " ":
                    break;

                default:
                    throw new \Exception("Unknown line type: " . $line);
            }
        }
    }

    public function getMethod(string $className, string $name, int $line): ?MappedMethod
    {
        return $this->methods[$name] ?? null;
    }

    public function getField(string $className, string $name): ?MappedField
    {
        return $this->fields[$name];
    }
}