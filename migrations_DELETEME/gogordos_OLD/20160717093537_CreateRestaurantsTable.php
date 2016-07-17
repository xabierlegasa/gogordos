<?php

class CreateRestaurantsTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $t = $this->create_table('restaurants', ['id'=> false]);
        $t->column(
            "id",
            "string",
            [
                "primary_key" => true,
                "null" => false,
                "limit" => 36
            ]
        );
        $t->column("name", "string", ["limit" => 250, "null" => false]);
        $t->column("city", "string", ["null" => false]);
        $t->column("category_id", "integer", ["null" => false]);
        $t->finish();

        $this->add_timestamps("restaurants");
        
        $this->add_index("restaurants", "id", ["unique" => true]);
        $this->add_index("restaurants", "name", ["unique" => true]);
    }

    public function down()
    {
        $this->drop_table("restaurants");
    }
}
