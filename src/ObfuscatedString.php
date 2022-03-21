<?php

namespace Aternos\Sherlock;

use Aternos\Sherlock\Maps\ObfuscationMap;

class ObfuscatedString
{
    protected ?string $deobfuscatedContent = null;

    public function __construct(protected string $content, protected ObfuscationMap $obfuscationMap)
    {
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    public function getMappedContent(): string
    {
        if ($this->deobfuscatedContent !== null) {
            return $this->deobfuscatedContent;
        }

        $this->deobfuscatedContent = "";
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $this->content) as $line) {
            if (!preg_match("/^(\s*)at (.+)\.([^.]+)\(([^:]+):(\d+)\)(.*)$/", $line, $matches)) {
                $this->deobfuscatedContent .= $line . "\n";
                continue;
            }

            [, $whitespace, $className, $methodName, $pretences, $lineNumber, $end] = $matches;
            $class = $this->obfuscationMap->getClass($className);
            if ($class === null) {
                $this->deobfuscatedContent .= $line . "\n";
                continue;
            }

            $method = $this->obfuscationMap->getMethod($className, $methodName, $lineNumber);
            if ($method !== null) {
                $methodName = $method->getName();
            }

            // client/optifine? file names
            if (preg_match("/^\s+\[$className\.class:\?]$/", $end)) {
                $end = " [" . $class->getName() . ".class:?]";
            }

            //Fabric file names
            if ("net.minecraft." . $pretences === $class->getUnmappedName() . ".java") {
                $pretences = $class->getName() . ".java";
            }

            $this->deobfuscatedContent .= "${whitespace}at " . $class->getPath() . ".$methodName($pretences:$lineNumber)$end\n";
        }

        return $this->deobfuscatedContent;
    }
}