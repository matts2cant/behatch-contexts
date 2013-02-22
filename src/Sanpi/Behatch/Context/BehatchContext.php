<?php

namespace Sanpi\Behatch\Context;

use Behat\Behat\Context\BehatContext;

class BehatchContext extends BehatContext
{
    private $parameters;

    public function getParameter($type, $extension, $name)
    {
        return $this->parameters[$type][$extension][$name];
    }

    public function hasParameter($type, $extension, $name)
    {
        return isset($this->parameters[$type][$extension][$name]);
    }

    public function setParameter($type, $extension, $name, $value)
    {
        $this->parameters[$type][$extension][$name] = $value;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        foreach ($this->parameters as $type => $parameters) {
            foreach ($parameters as $name => $values) {
                $type = preg_replace('/s$/', '', $type);
                $className = '\\Sanpi\\Behatch\\' . ucfirst($type) . '\\' . ucfirst($name) . ucfirst($type);
                $this->useContext($name, new $className($parameters));
            }
        }
    }
}
