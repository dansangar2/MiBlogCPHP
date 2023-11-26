<?php

namespace App\Controller\Component;

use App\Controller\AppController;

abstract class GestionController extends AppController
{
    public static $ListingMethod = "index";
    public static $ViewMethod = "view";
    public static $AddMethod = "add";
    public static $EditMethod = "edit";
    public static $DeleteMethod = "delete";

    public function isAuthorized($user)
    {
        if(in_array($this->request->action, ['edit', 'delete']))
        {
            $id = $this->request->getParam('pass', 0);
            $item = $this->item()->get($id);
            if(!isset($item->user_id) || $item->user_id == $user['id'])
            {
                return true;
            }
            return $this->redirect("/posts/index");
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->paginate = ['order' => ['modified' => 'desc']];
        $items = $this->paginate($this->item());
        $this->set($this->itemName(), $items);
    }

    public function view($id)
    {
        $item = $this->item()->get($id);
        $readonly = true;
        $desc = $item->name;
        $this->set(compact('item'));
        $this->set(compact('readonly'));
        $this->set(compact('desc'));
        foreach ($this->paramsToViewWindows() as $k => $v)
        {
            $item->$k = $v;
            $this->set(compact($k));
        }
        return $this->render($this->itemName() . "_view");
    }

    public function add()
    {
        $item = $this->item()->newEntity();
        if($this->request->is('post'))
        {
            $item = $this->item()->patchEntity($item, $this->request->getData());
            foreach ($this->paramsToAddWindows() as $k => $v)
            {
                $item->$k = $v;
            }
            if($this->item()->save($item))
            {
                if($this->successRedirect()!=null)
                {
                    $this->Flash->success('Creado correctamente.');
                }
            }
            else
            {
                $this->Flash->error('No se ha podido crear.');
            }
        }
        $desc = $this->headerDescriptions()['add'];
        $this->set(compact('item'));
        $this->set(compact('desc'));
        return $this->render($this->itemName() . "_view");
    }

    public function edit($id)
    {
        $item = $this->item()->get($id);

        if($this->request->is(['post', 'patch', 'put']))
        {
            $item = $this->item()->patchEntity($item, $this->request->getData());
            foreach ($this->paramsToUpdateWindows() as $k => $v)
            {
                $item->$k = $v;
            }
            if($this->item()->save($item))
            {
                if($this->successRedirect()!=null)
                {
                    $this->Flash->success('Guardado correctamente.');
                }
            }
            else
            {
                $this->Flash->success('No se ha podido guardar.');
            }
        }
        $desc = $this->headerDescriptions()['edit'];
        $this->set(compact('item'));
        $this->set(compact('desc'));
        return $this->render($this->itemName() . "_view");
    }

    public function delete($id)
    {
        $item = $this->item()->get($id);

        $redirect = ['action' => 'index'];
        $requests = ['post', 'delete'];

        //Debería redireccionar a index o a un mensaje de "acción prohíbida" si se intenta borrar por URL.
        if(!$this->request->is($requests))
        {
            return $this->redirect($redirect);
        }

        //Si la primera comprobación no es eficaz, entonces lanzará el error como segunda medida de seguridad.
        $this->request->allowMethod($requests);

        if($this->item()->delete($item)) {
            $this->Flash->success('Borrado correctamente');
        } else {
            $this->Flash->success('No se ha podido borrar.');
        }

        return $this->redirect($redirect);
    }

    abstract function item();
    abstract function itemName();
    abstract function successRedirect();
    abstract function paramsToAddWindows();
    abstract function paramsToViewWindows();
    abstract function paramsToUpdateWindows();
    abstract function headerDescriptions();
}