<?php

namespace App\Controller;

use App\Controller\Component\GestionController;
use Cake\ORM\TableRegistry;

class CommentsController extends AppController
{

    public function index()
    {
        $postId = $this->getRequest()->getParam('id');
        $post = TableRegistry::getTableLocator()->get('Posts')->get($postId);
        $newPost = $this->Comments->newEntity();
        $this->paginate = ['conditions' => ['post_id' => $postId], 'order' => ['modified' => 'desc']];
        $items = $this->paginate($this->Comments);

        if($this->request->is('post'))
        {
            $newPost->user_id = $this->Auth->user('id');
            $newPost->post_id = $postId;
            $newPost = $this->item()->patchEntity($newPost, $this->request->getData());
            if($this->item()->save($newPost)) {
                $this->Flash->success('Comentario posteado correctamente');
                return $this->redirect('/posts/comments/' . $postId);
            } else {
                $this->Flash->success('Tu comentario no se ha podido subir');
            }
        }

        $this->set('comments', $items);
        $this->set('newPost', $newPost);
        $this->set('post', $post);

    }

    public function delete($id)
    {
        $item = $this->item()->get($id);

        $postId = $item->post_id;
        $redirect = ['controller' => 'Posts' , 'action' => 'comments/' . $postId];
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

    function item()
    {
        return $this->Comments;
    }
}