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
                if (preg_match("/^(\s*)at (.+)\.([^.]+)\(([^:]+):(\d+)\)(.*)$/", $line, $matches)) {
                    [,$whitespace, $className, $methodName, $pretences, $lineNumber, $end] = $matches;
                    $class = $this->obfuscationMap->getClass($className);
                    if ($class !== null) {
                        $method = $this->obfuscationMap->getMethod($className, $methodName, $lineNumber);
                        if ($method !== null) {
                            $methodName = $method->getName();
                        }

                        // client/optifine? file names
                        if (preg_match("/^\s+\[$className\.class:\?]$/", $end)) {
                            $end = " [" . $class->getName() . ".class:?]";
                        }

                        //Fabric file names
                        if ("net.minecraft." . $pretences === $class->getUnmappedName()  . ".java") {
                            $pretences = $class->getName() . ".java";
                        }

                        $this->deobfuscatedContent .= "${whitespace}at " . $class->getPath() . ".$methodName($pretences:$lineNumber)$end\n";
                        continue;
                    }
                }
                $this->deobfuscatedContent .= $line . "\n";
            }
        }

        return $this->deobfuscatedContent;
    }
}