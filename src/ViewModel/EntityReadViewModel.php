<?php

namespace T4web\Admin\ViewModel;

use T4webDomainInterface\EntityInterface;
use Sebaks\View\ViewModel as SebaksViewModel;

class EntityReadViewModel extends SebaksViewModel
{
    public function getVariable($name, $default = null)
    {
        $variable = parent::getVariable($name, $default);

        if ($name == 'result') {
            if (! $variable instanceof EntityInterface) {
                throw new \RuntimeException('Variable result must be instance of ' . EntityInterface::class . '. '
                    . gettype($variable) . ' given');
            }
            $variable = $variable->extract();
        }

        return $variable;
    }
}