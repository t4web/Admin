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
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $options = [];

    /**
     * Config constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
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
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @param string $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @param string $entity
     */
    public function getActionViewModel()
    {
        $entityAlias = $this->module . '-' . $this->entity;

        return $this->options[$entityAlias]['actions'][$this->action]['viewModel'];
    }

    public function getActionRedirect()
    {
        $entityAlias = $this->module . '-' . $this->entity;

        return $this->options[$entityAlias]['actions'][$this->action]['redirect'];
    }




    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
//
//    public function getViewModel()
//    {
//        $viewModel = 'T4webAdmin\View\Model\CreateViewModel';
//
//        if (!empty($this->options['viewModel'])) {
//            $viewModel = $this->options['viewModel'];
//        }
//
//        return $viewModel;
//    }
//
//    public function getTemplate()
//    {
//        $template = 't4web-admin/entity-manage';
//
//        if (!empty($this->options['template'])) {
//            $template = $this->options['template'];
//        }
//
//        return $template;
//    }
//
//    public function getTitle()
//    {
//        $title = 'Create new entity';
//
//        if (!empty($this->options['title'])) {
//            $title = $this->options['title'];
//        }
//
//        return $title;
//    }
//
//
//
//
//
//
//    public function getCreateViewController()
//    {
//        $controller = 'create';
//
//        if (!empty($this->options['create']['controller'])) {
//            $controller = $this->options['create']['controller'];
//        }
//
//        return $controller;
//    }
//
//    public function getCreateViewSubmitText()
//    {
//        $text = 'Create';
//
//        if (!empty($this->options['create']['submitText'])) {
//            $text = $this->options['create']['submitText'];
//        }
//
//        return $text;
//    }
//
//
//
//    public function getReadViewModelTemplate()
//    {
//        $template = 't4web-admin/entity-manage';
//
//        if (!empty($this->options['read']['template'])) {
//            $template = $this->options['read']['template'];
//        }
//
//        return $template;
//    }
//
//    public function getReadViewController()
//    {
//        $controller = 'update';
//
//        if (!empty($this->options['read']['controller'])) {
//            $controller = $this->options['read']['controller'];
//        }
//
//        return $controller;
//    }
//
//    public function getReadViewSubmitText()
//    {
//        $text = 'Save';
//
//        if (!empty($this->options['read']['submitText'])) {
//            $text = $this->options['read']['submitText'];
//        }
//
//        return $text;
//    }
//
//    public function getReadViewModelTitle()
//    {
//        $title = 'Edit entity';
//
//        if (!empty($this->options['read']['title'])) {
//            $title = $this->options['read']['title'];
//        }
//
//        return $title;
//    }
//
//    public function getUpdateViewModelTemplate()
//    {
//        $template = 't4web-admin/entity-manage';
//
//        if (!empty($this->options['update']['template'])) {
//            $template = $this->options['update']['template'];
//        }
//
//        return $template;
//    }
//
//    public function getUpdateViewController()
//    {
//        $controller = 'update';
//
//        if (!empty($this->options['update']['controller'])) {
//            $controller = $this->options['update']['controller'];
//        }
//
//        return $controller;
//    }
//
//    public function getUpdateViewSubmitText()
//    {
//        $text = 'Save';
//
//        if (!empty($this->options['update']['submitText'])) {
//            $text = $this->options['update']['submitText'];
//        }
//
//        return $text;
//    }
//
//    public function getUpdateViewModelTitle()
//    {
//        $title = 'Edit entity';
//
//        if (!empty($this->options['update']['title'])) {
//            $title = $this->options['update']['title'];
//        }
//
//        return $title;
//    }
//
//
//    public function getFormTemplate()
//    {
//        $template = 't4web-admin/form';
//
//        if (!empty($this->options['form']['template'])) {
//            $template = $this->options['form']['template'];
//        }
//
//        return $template;
//    }
//
//    public function getFormElements()
//    {
//        $elements = [];
//
//        if (!empty($this->options['form']['elements'])) {
//            $elements = $this->options['form']['elements'];
//        }
//
//        return $elements;
//    }
//
//    public function getFormElementTemplate(array $element)
//    {
//        $elementTemplate = 't4web-admin/' . $element['type'];
//
//        if (!empty($element['template'])) {
//            $elementTemplate = $element['template'];
//        }
//
//        return $elementTemplate;
//    }
//
//    public function getRoute()
//    {
//        return 'admin-' . $this->module . '-' . $this->entity;
//    }
//
//    public function getCreateRedirectTo()
//    {
//        return 'admin-' . $this->module . '-' . $this->entity;
//    }
//
//    public function getValidation()
//    {
//        $validation = [];
//
//        if (!empty($this->options['validation'])) {
//            $validation = $this->options['validation'];
//        }
//
//        return $validation;
//    }
}
