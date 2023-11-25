<?php
/**
 * @var \App\View\AppView                                             $this
 * @var \App\Model\Entity\Post[]|\Cake\Collection\CollectionInterface $post
 */
?>
<?= $this->element('menu') ?>
<div class="posts index large-9 medium-8 columns content">
    <h2>¡Hola, <?= $this->Html->link( $current_user['name'], ['controller' => 'Users', 'action' => 'view', $current_user['id']])?>!</h2>
    <h3><?= __('Posts') ?></h3>
    <?= $this->Html->link(__('Nuevo Post'), ['action' => 'add']) ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tittle') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($post as $p): ?>
            <tr>
                <td><?= $this->Number->format($p->id) ?></td>
                <td><?= h($p->tittle) ?></td>
                <td><?= $p->has('user') ? $this->Html->link($p->user->name, ['controller' => 'Users', 'action' => 'view', $p->user->id]) : '' ?></td>
                <td><?= $p->has('category') ? $this->Html->link($p->category->name, ['controller' => 'Categories', 'action' => 'view', $p->category->id]) : '' ?></td>
                <td><?= h($p->created) ?></td>
                <td><?= h($p->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $p->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $p->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $p->id], ['confirm' => __('Are you sure you want to delete # {0}?', $p->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
