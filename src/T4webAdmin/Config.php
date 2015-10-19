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

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function getCreateViewModelTemplate()
    {
        $template = 't4web-admin/entity-manage';

        if (!empty($this->options['create']['template'])) {
            $template = $this->options['create']['template'];
        }

        return $template;
    }

    public function getCreateViewController()
    {
        $controller = 'create';

        if (!empty($this->options['create']['controller'])) {
            $controller = $this->options['create']['controller'];
        }

        return $controller;
    }

    public function getCreateViewSubmitText()
    {
        $text = 'Create';

        if (!empty($this->options['create']['submitText'])) {
            $text = $this->options['create']['submitText'];
        }

        return $text;
    }

    public function getCreateViewModelTitle()
    {
        $title = 'Create new entity';

        if (!empty($this->options['create']['title'])) {
            $title = $this->options['create']['title'];
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

    public function getCreateRedirectTo()
    {
        return 'admin-' . $this->module . '-' . $this->entity;
    }

    public function getValidation()
    {
        $validation = [];

        if (!empty($this->options['validation'])) {
            $validation = $this->options['validation'];
        }

        return $validation;
    }
}
