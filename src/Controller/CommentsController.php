<?php

namespace App\Controller;

use App\Controller\Component\GestionController;
use Cake\ORM\TableRegistry;

class CommentsController extends GestionController
{

    public function index()
    {
        $postId = $this->getRequest()->getParam('id');
        $post = TableRegistry::getTableLocator()->get('Posts')->get($postId);
        $newPost = $this->Comments->newEntity();
        $this->paginate = ['conditions' => ['post_id' => $postId]];
        $items = $this->paginate($this->Comments);

        if($this->request->is('post'))
        {
            $newPost->user_id = $this->Auth->user('id');
            $newPost->post_id = $postId;
            $newPost = $this->item()->patchEntity($newPost, $this->request->getData());
            debug($this->request->getData());
            if($this->item()->save($newPost))
            {
                $newPost = $this->Comments->newEntity();
                $this->Flash->success('Comentario posteado correctamente');
            }
            else
            {
                $this->Flash->success('Tu comentario no se ha podido subir');
            }
        }

        $this->set('comments', $items);
        $this->set('newPost', $newPost);
        $this->set('post', $post);

    }

    function item()
    {
        return $this->Comments;
    }

    function itemName()
    {
        return 'comment';
    }

    function successMessage()
    {
        return 'Comentario guardado correctamente';
    }

    function errorMessage()
    {
        return 'El Comentario no se ha podido guardar';
    }

    function paramsToViewWindows()
    {
        return [];
    }

    function successRedirect()
    {
        return $this->redirect('/comments/index');
    }

    function paramsToAddWindows()
    {
        return [];
    }
}