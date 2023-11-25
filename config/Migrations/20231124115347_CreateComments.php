<?php
use Migrations\AbstractMigration;

class CreateComments extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('comments');
        $table->addColumn('content', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        $ref = $this->table('comments');
        $ref->addColumn('user_id', 'integer', [
            'signed' => 'disable',
        ])->addForeignKey('user_id', 'users', 'id',
            [
                'delete' => 'CASCADE', 'update' => 'NO_ACTION'
            ]
        )->update();
        $ref->addColumn('post_id', 'integer', [
            'signed' => 'disable',
        ])->addForeignKey('post_id', 'posts', 'id',
            [
                'delete' => 'CASCADE', 'update' => 'NO_ACTION'
            ]
        )->update();
    }
}
