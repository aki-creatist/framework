<?php

namespace Framework\Console;

class CommandLineParser
{
    public ?string $uri;
    public array $options;

    public function __construct(array $argv)
    {
        $this->parseArguments($argv);
    }

    private function parseArguments(array $argv): void
    {
        // スクリプト名を除外
        array_shift($argv);

        $this->options = [];
        $this->uri = null;

        foreach ($argv as $arg) {
            if (str_starts_with($arg, '--')) {
                $eqPos = strpos($arg, '=');
                if ($eqPos !== false) {
                    $key = substr($arg, 2, $eqPos - 2);
                    $value = substr($arg, $eqPos + 1);
                } else {
                    $key = substr($arg, 2);
                    $value = true; // 値がない場合は true とする
                }

                if ($key === 'uri') {
                    $this->uri = $value;
                } else {
                    $this->options[$key] = $value;
                }
            }
        }
    }
}
