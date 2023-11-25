<?php

namespace App\Controller;

use App\Controller\Component\GestionController;
use Cake\ORM\TableRegistry;

class PostsController extends GestionController
{

    public function isAuthorized($user)
    {
        if(in_array($this->request->action, ['edit', 'delete'])) {
            $post = $this->Posts->get($this->request->getParam('pass', 0));
            print $post;
            return $post->user_id == $user['id'];
        }
        return parent::isAuthorized($user);
    }

    public function view($id)
    {
        $item = $this->item()->get($id);
        $comments = TableRegistry::getTableLocator()->get('Comments')->find();
        $readonly = true;
        $desc = $item->name;
        debug($comments);
        $this->set(compact('item'));
        $this->set(compact('readonly'));
        $this->set(compact('desc'));
        $this->set(compact('comments'));
        foreach ($this->paramsToViewWindows() as $k => $v)
        {
            $item->$k = $v;
            $this->set(compact($k));
        }
        return $this->render($this->itemName() . "_view");//, compact('item', 'readonly'));
    }

    function item()
    {
        return $this->Posts;
    }

    function itemName()
    {
        return 'post';
    }

    function successMessage()
    {
        return 'Mensaje guardado correctamente';
    }

    function errorMessage()
    {
        return 'El Mensaje no se ha podido guardar';
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
}