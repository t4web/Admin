# Admin

## Installation

Add this project in your composer.json:

```json
"require": {
    "t4web/admin": "~2.0.0"
}
```

Now tell composer to download Authentication by running the command:

```bash
$ php composer.phar update
```

#### Post installation

Enabling it in your `application.config.php`file.

```php
<?php
return array(
    'modules' => array(
        // ...
        'Sebaks\View',
        'Sebaks\ZendMvcController',
        'T4web\Admin',
    ),
    // ...
);
```

Admin module

Problem: when you create entity, you must coding the same CRUD with different entity fields everytime for each entity. Typicaly CRUD Controllers:
```php
class ListController
{
    public function indexAction()
    {
        // get and validate some filter
        $query = $this->inputFilter->filter($this->query);
        
        // find entities collection
        $collection = $this->finder->findMany($query);
        
        // set collection in view model
        $this->viewModel->setCollection($collection);
        
        // in template iterate by collection and show table with entities
        return $this->viewModel;
    }
}

class CreateController
{
    public function indexAction()
    {
        // just show creation form if request is not post
        if (!$this->getRequest()->isPost()) {
            return $this->view;
        }

        // getting entity data from request
        $params = $this->getRequest()->getPost()->toArray();

        // validating and creating entity in storage
        $entity = $this->createService->create($params);

        // if errors occurs - show creation form with error messages
        if (!$entity) {
            // for showing user filled data
            $this->view->setFormData($params);
            // for showing validation messages
            $this->view->setErrors($this->createService->getErrors());
            return $this->view;
        }

        // entity successfuly created - show it or redirect to list
        $params['entityId'] = $entity->getId();
        $this->view->setFormData($params);

        // in template show created entity
        return $this->view;
    }
}

class UpdateController
{
    public function readAction()
    {
        // get entity id
        $id = $this->params('id', null);

        // fetch entity from storage
        $entity = $this->serviceFinder->find(['id' => $id]);
        
        // if not fetched - show error
        if (!$entity) {
            throw new NotFoundExeption("Entity with id #$id not exists.");
        }

        $this->view->setEntity($entity);
  
        // in template showing form with entity
        return $this->view;
    }
    
    public function saveAction()
    {
        // just show creation form if request is not post
        if (!$request->isPost()) {
            throw new InvalidExeption("Operation not allowed");
        }

        // get entity data from request
        $params = $request->getPost()->toArray();

        // validate and update entity in storage
        $entity = $updateService->update($params['id'], $params);

        // if error ocurs
        if (!$employee) {
            // for showing user filled data
            $this->view->setFormData($params);
            // for showing validation messages
            $this->view->setErrors($updateService->getErrors());
            return $view;
        }

        // entity successfuly created - show it or redirect to list
        $params['entityId'] = $entity->getId();
        $view->setFormData($params);

        return $view;
    }
}

class DeleteController
{
    public function indexAction()
    {
        // get entity id
        $id = $this->params('id', null);

        // fetch entity from storage
        $entity = $this->serviceFinder->find(['id' => $id]);
        
        // if not fetched - show error
        if (!$entity) {
            throw new NotFoundExeption("Entity with id #$id not exists.");
        }

        if (!$deleteService->delete($id)) {
            throw new InvalidExeption("Somthing wrong, when deleting entity #$id.");
        }
  
        // redirect ti list
        return $this->redirect('entity-list');
    }
}
```
That is general workflow for most cases.

If you look closely - it's the same workflow for any entity.

This module resolve this workflow - just configure entity.
