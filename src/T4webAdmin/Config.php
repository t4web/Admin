<?php

namespace T4webAdmin;

class Config
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $entity;

    /**
     * @var array
     */
    private $options = [];

    /**
     * Config constructor.
     * @param string $module
     * @param string $entity
     * @param array $options
     */
    public function __construct($module, $entity, array $options)
    {
        $this->module = $module;
        $this->entity = $entity;
        $this->options = $options;
    }

    public function getNewViewModelTemplate()
    {
        $template = 't4web-admin/entity-manage';

        if (!empty($this->options['new']['template'])) {
            $template = $this->options['new']['template'];
        }

        return $template;
    }

    public function getNewViewModelTitle()
    {
        $title = 'Create new entity';

        if (!empty($this->options['new']['title'])) {
            $title = $this->options['new']['title'];
        }

        return $title;
    }

    public function getFormTemplate()
    {
        $template = 't4web-admin/form';

        if (!empty($this->options['form']['template'])) {
            $template = $this->options['form']['template'];
        }

        return $template;
    }

    public function getFormElements()
    {
        $elements = [];

        if (!empty($this->options['form']['elements'])) {
            $elements = $this->options['form']['elements'];
        }

        return $elements;
    }

    public function getFormElementTemplate(array $element)
    {
        $elementTemplate = 't4web-admin/' . $element['type'];

        if (!empty($element['template'])) {
            $elementTemplate = $element['template'];
        }

        return $elementTemplate;
    }

    public function getRoute()
    {
        return 'admin-' . $this->module . '-' . $this->entity;
    }
}
