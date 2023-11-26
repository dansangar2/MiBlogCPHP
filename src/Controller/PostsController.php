<?php

namespace App\Controller;

use App\Controller\Component\GestionController;

class PostsController extends GestionController
{

    public function view($id)
    {
        return $this->redirect(['action' => 'comments/' . $id]);
    }

    public function yourindex()
    {
        $userId = $this->request->getParam('userId');

        $this->paginate = ['conditions' => ['user_id' => $userId], 'order' => ['modified' => 'desc']];
        $items = $this->paginate($this->item());
        $this->set($this->itemName(), $items);
        $your = 'your';
        $this->set('your', $your);

        return $this->render("index");
    }

    function item()
    {
        return $this->Posts;
    }

    function itemName()
    {
        return 'post';
    }


    function successRedirect()
    {
        return $this->redirect('/posts/index');
    }

    function paramsToAddWindows()
    {
        return ['user_id' => $this->Auth->user('id')];
    }

    function paramsToViewWindows()
    {
        return [];
    }

    function paramsToUpdateWindows()
    {
        return [];
    }

    function headerDescriptions()
    {
        return['edit' => 'Modifica Post', 'add' => 'Agregar un nuevo blog'];
    }
}