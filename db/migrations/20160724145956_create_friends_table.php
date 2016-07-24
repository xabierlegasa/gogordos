<?php

use Phinx\Migration\AbstractMigration;

class CreateFriendsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $users = $this->table('friends', ['id' => false]);
        $users->addColumn('user_id_follower', 'string', ['limit' => 36])
            ->addColumn('user_id_following', 'string', ['limit' => 36])
            ->addColumn('created_at', 'datetime')
            ->addForeignKey('user_id_follower', 'users', ['id'], ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addForeignKey('user_id_following', 'users', ['id'], ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addIndex(['user_id_follower', 'user_id_following'], ['unique' => true])
            ->save();
    }
}
