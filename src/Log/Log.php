<?php

namespace Aternos\Sherlock\Log;

use Aternos\Sherlock\Maps\ObfuscationMap;

class Log
{
    protected string $content;
    protected ObfuscationMap $obfuscationMap;
    protected ?string $deobfuscatedContent = null;

    public function __construct(string $content, ObfuscationMap $obfuscationMap)
    {
        $this->content = $content;
        $this->obfuscationMap = $obfuscationMap;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    public function getDeobfuscatedContent(): string
    {
        if ($this->deobfuscatedContent === null) {
            $this->deobfuscatedContent = "";
            foreach (preg_split("/((\r?\n)|(\r\n?))/", $this->content) as $line) {
                if (preg_match("/^(\s*)at (.+)\.([^.]+)\(SourceFile:(\d+)\)(.*)$/", $line, $matches)) {
                    [,$whitespace, $className, $methodName, $lineNumber, $end] = $matches;
                    $class = $this->obfuscationMap->getClass($className);
                    if ($class !== null) {
                        $method = $class->getMethod($methodName, $lineNumber);
                        if ($method !== null) {
                            $methodName = $method->getName();
                        }

                        if (preg_match("/^\s+\[$className\.class:\?]$/", $end, $endMatches)) {
                            $end = " [" . $class->getName() . ".class:?]";
                        }

                        $this->deobfuscatedContent .= $whitespace . "at " . $class->getPath() . "." . $methodName . "(SourceFile:" . $lineNumber . ")" . $end . "\n";
                        continue;
                    }
                }
                $this->deobfuscatedContent .= $line . "\n";
            }
        }

        return $this->deobfuscatedContent;
    }
}