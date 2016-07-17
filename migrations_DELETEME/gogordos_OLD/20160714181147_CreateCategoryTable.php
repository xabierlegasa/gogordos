<?php

class CreateCategoryTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $t = $this->create_table('category', ['id'=> false]);

        $t->column('id', 'integer', [
                'primary_key' => true,
                'auto_increment' => true,
                'null' => false
            ]
        );
        $t->column("name", "string", ["limit" => 75, "null" => false]);
        $t->column("name_es", "string", ["limit" => 75, "null" => false]);
        $t->finish();

        // add created_at and updated_at columns
        $this->add_timestamps("category");

        $this->add_index("category", "id", ["unique" => true]);
        $this->add_index("category", "name", ["unique" => true]);
        $this->add_index("users", "created_at", ["unique" => false]);
    }

    public function down()
    {
        $this->drop_table("category");
    }
}
