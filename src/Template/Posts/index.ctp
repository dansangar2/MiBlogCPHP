<?php
/**
 * @var \App\View\AppView                                             $this
 * @var \App\Model\Entity\Post[]|\Cake\Collection\CollectionInterface $post
 */

use Cake\ORM\TableRegistry;

?>
<?= $this->element('menu') ?>
<div class="posts index large-9 medium-8 columns content">
    <h2>¡Hola, <?= $this->Html->link( $current_user['name'], ['controller' => 'Users', 'action' => 'view', $current_user['id']])?>!</h2>
    <h3><?= __('Posts') ?></h3>
    <?= $this->Html->link(__('Nuevo Post'), ['action' => 'add']) ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('tittle', 'Título') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id', 'Usuario') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id', 'Categoría') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created', 'Creado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                <th scope="col" class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = TableRegistry::getTableLocator()->get('Users');
            $categories = TableRegistry::getTableLocator()->get('Categories');
            foreach ($post as $p):

                ?>
            <tr>
                <td><?= h($p->tittle) ?></td>
                <td><?= h($users->get($p->user_id)->name) ?></td>
                <td><?= h($categories->get($p->category_id)->name) ?></td>
                <td><?= h($p->created) ?></td>
                <td><?= h($p->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => '/comments/', $p->id]) ?>
                    <?php if($p->user_id === $current_user['id']): ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $p->id]) ?>
                        <?= $this->Form->postLink(__('Borrar'), ['action' => 'delete', $p->id], ['confirm' => __('¿Seguro que quieres borrarlo?', $p->id)]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('Primero')) ?>
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('Último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Página {{page}} / {{pages}}, viendo {{current}} de {{count}} ')]) ?></p>
    </div>
</div>
