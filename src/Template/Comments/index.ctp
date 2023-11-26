<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment[]|\Cake\Collection\CollectionInterface $comments
 */

use App\Controller\CategoriesController;
use Cake\ORM\TableRegistry;

?>
<?= $this->element('menu') ?>
<div class="comments index large-9 medium-8 columns content">

    <div>
    <?php
    echo "<div>
            <h2 style='float: left;'>$post->tittle</h2>
            <h3 style='text-align: right;'> Categoría: "
            . (new CategoriesController())->Categories->get($post->category_id)->name . "</h3>
          </div>";
    echo "<textarea readonly style='width: 947px; height: 187px;'>$post->content</textarea>";
    ?>
    </div>
    <div class="comments form large-9 medium-8 columns content">
        <?= $this->Form->create($newPost) ?>
        <fieldset>
            <legend><?= __('Agregar Comentario') ?></legend>
            <?php
            echo $this->Form->control('content', ['value' => '']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Comentar')) ?>
        <?= $this->Form->end() ?>
    </div>
    <div>
        <div class="comments form large-12 medium-8 columns content">
            <div>
                <h3><?= __('Comentarios') ?></h3>
            </div>
            <table cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th scope="col" colspan="3">Comentario</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Creado</th>
                    <th scope="col">Modificado</th>
                    <th scope="col">Borrar</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $users = TableRegistry::getTableLocator()->get('Users');

                foreach ($comments as $comment): ?>
                    <tr>
                        <td colspan="3"><?= h($comment->content) ?></td>
                        <td><?= h($users->get($comment->user_id)->name)?></td>
                        <td><?= h($comment->created) ?></td>
                        <td><?= h($comment->modified) ?></td>
                        <td class="actions">
                            <?php if($comment->user_id == $current_user['id']): ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comment->id]);//, ['confirm' => __('¿Estás seguro que quieres borrarlo?', $comment->id)]) ?>
                            <?php endif; ?>
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
    </div>
</div>
