<?php

class FillInCategoryTable extends Ruckusing_Migration_Base
{
    private $categories = [
        'americano' => 'Americano',
        'andaluz' => 'Andaluz',
        'arabe' => 'Árabe',
        'argentino' => 'Argentino',
        'arroceria' => 'Arrocería',
        'asador' => 'Asador',
        'asiatico' => 'Asiático',
        'asturiano' => 'Asturiano',
        'belga' => 'Belga',
        'braseria_carnes' => 'Brasería. Carnes',
        'brasileño' => 'Brasileño',
        'camboyano' => 'Camboyano',
        'castellano' => 'Castellano',
        'catalan' => 'Catalán',
        'chino' => 'Chino',
        'colombiano' => 'Colombiano',
        'coreano' => 'Coreano',
        'creativo' => 'Creativo',
        'cubano' => 'Cubano',
        'de_fusion' => 'De Fusión',
        'de_mercado' => 'De Mercado',
        'espanol' => 'Español',
        'etiope' => 'Etíope',
        'europa_del_este' => 'Europa del este',
        'extrameno' => 'Extremeño',
        'frances' => 'Francés',
        'gallego' => 'Gallego',
        'griego' => 'Griego',
        'indio' => 'Indio',
        'ingles' => 'Inglés',
        'internacional' => 'Internacional',
        'irani' => 'Iraní',
        'italiano' => 'Italino',
        'japones' => 'Japonés',
        'latino' => 'Latino',
        'libanes' => 'Libanés',
        'marisqueria' => 'Marisquería',
        'marroqui' => 'Marroquí',
        'mediterraneo' => 'Mediterraneo',
        'mexicano' => 'Mexicano',
        'navarro' => 'Navarro',
        'peruano' => 'Peruano',
        'portugues' => 'Portugués',
        'suizo' => 'Suizo',
        'ruso' => 'Ruso',
        'suizo' => 'Suizo',
        'tailandes' => 'Tailandés',
        'turco' => 'Turco',
        'vasco' => 'Vasco',
        'vegetariano' => 'Vegetariano',
        'vietnamita' => 'Vietnamita'
    ];

    public function up()
    {
        foreach ($this->categories as $key => $value) {
            $this->execute(
                "INSERT INTO `category` (`name`, `name_es`, `created_at`) VALUES('" .
                $this->quote_string($key) .
                "', '" .
                $this->quote_string($value) .
                "', '" .
                date('Y-m-d H:i:s') .
                "');");
        }
    }

    public function down()
    {
        $this->execute('TRUNCATE TABLE category');
    }
}
