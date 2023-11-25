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

    public function index()
    {
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
        return $this->render($this->itemName() . "_view");//, compact('item', 'readonly'));
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
                $this->Flash->success($this->successMessage());
                if($this->successRedirect()!=null)
                {
                    return $this->successRedirect();
                }
            }
            else
            {
                $this->Flash->success($this->errorMessage());
            }
        }
        $desc = "Añadir Usuario";
        $this->set(compact('item'));
        $this->set(compact('desc'));
        return $this->render($this->itemName() . "_view");//, compact('post'));
    }

    public function edit($id)
    {
        $post = $this->Users->findById($id);
        return $this->render('edit', compact('post'));
    }

    public function delete($id)
    {
        $this->Users->delete($id);
        return $this->redirect('/');
    }

    abstract function item();
    abstract function itemName();
    abstract function paramsToViewWindows();
    abstract function successMessage();
    abstract function successRedirect();
    abstract function paramsToAddWindows();
    abstract function errorMessage();
}