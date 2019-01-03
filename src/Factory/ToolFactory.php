<?php

namespace Tooly\Factory;

use Tooly\Model\Tool;

/**
 * @package Factory
 */
class ToolFactory
{
    /**
     * @param string $name
     * @param string $directory
     * @param array  $parameters
     *
     * @return Tool
     */
    public static function createTool($name, $directory, array $parameters)
    {
        $defaults = [
            'url' => null,
            'sign-url' => null,
            'pub-key-url' => null,
            'only-dev' => true,
            'force-replace' => false,
        ];

        $parameters = array_merge($defaults, $parameters);

        $tool = new Tool(
            $name,
            self::getFilename($name, $directory),
            $parameters['url'],
            $parameters['sign-url'],
            $parameters['pub-key-url']
        );

        if (true === $parameters['force-replace']) {
            $tool->activateForceReplace();
        }

        if (false === $parameters['only-dev']) {
            $tool->disableOnlyDev();
        }

        return $tool;
    }

    /**
     * @param string $directory
     * @param array  $data
     *
     * @return array
     */
    public static function createTools($directory, array $data)
    {
        $tools = [];

        foreach ($data as $name => $parameters) {
            $tools[$name] = self::createTool($name, $directory, $parameters);
        }

        return $tools;
    }

    /**
     * @param string $name
     * @param string $directory
     *
     * @return string
     */
    private static function getFilename($name, $directory)
    {
        $filename = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $filename .= str_replace('.phar', '', $name) . '.phar';

        return $filename;
    }
}
