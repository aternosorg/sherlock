<?php

namespace Aternos\Sherlock\Maps;

use Aternos\Sherlock\MappedData\MappedClass;
use Aternos\Sherlock\MappedData\MappedField;
use Aternos\Sherlock\MappedData\MappedMethod;
use Aternos\Sherlock\MappedData\VanillaMappedClass;

class VanillaObfuscationMap extends ObfuscationMap
{
    public function parseMappings(): void
    {
        $class = null;
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $this->content) as $line) {
            if ($line === "" || str_starts_with($line, "#")) {
                continue;
            }

            if (str_starts_with($line, " ")) {
                if (preg_match("/^\s+(\d+):(\d+):([^\s]+) ([^\s(]+)\s?\(([^)]*)\) -> ([^\s]+)$/", $line, $matches)) {
                    if ($class === null) {
                        throw new \Exception("Method found before class!");
                    }
                    [,$start, $end, $returnType, $name, , $unmappedName] = $matches;
                    $class->addMethod(new MappedMethod($class, (int) $start, (int) $end, $name, $unmappedName));
                }
                else if (preg_match("/^\s+([^\s]+) ([^\s]+) -> ([^\s]+)$/", $line, $matches)) {
                    if ($class === null) {
                        throw new \Exception("Field found before class!");
                    }

                    $field = new MappedField($class, ...array_slice($matches, 1));
                    $class->addField($field, $field->getUnmappedName());
                }
                else {
                    throw new \Exception("Invalid field/method line: " . $line);
                }
                continue;
            }

            if (!preg_match("/^([^\s]+) -> ([^\s]+):$/", $line, $matches)) {
                throw new \Exception("Invalid class name found: " . $line);
            }

            $classPath = $matches[1];
            $unmappedName = $matches[2];
            $class = new MappedClass($classPath, $unmappedName);
            $this->addClass($class);
        }
    }
}