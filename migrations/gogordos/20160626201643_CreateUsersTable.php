<?php

class CreateUsersTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $t = $this->create_table('users', ['id'=> false]);
        $t->column(
            "id",
            "string",
            [
                "primary_key" => true,
                "null" => false,
                "limit" => 36
            ]
        );
        $t->column("email", "string", ["limit" => 128, "null" => false]);
        $t->column("username", "string", ["null" => false]);
        $t->column("password_hash", "string", ["limit" => 255, "null" => false]);
        $t->finish();

        $this->add_timestamps("users");
        
        $this->add_index("users", "id", ["unique" => true]);
        $this->add_index("users", "email", ["unique" => true]);
        $this->add_index("users", "username", ["unique" => true]);
    }

    public function down()
    {
        $this->drop_table("users");
    }
}
