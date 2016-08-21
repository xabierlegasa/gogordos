<?php

use Phinx\Migration\AbstractMigration;

class FillInCategoriesTable extends AbstractMigration
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
        'otro' => 'Otros',
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

    /**
     * Migrate Up.
     */
    public function up()
    {
        $rows = [];

        foreach ($this->categories as $key => $value) {
            $rows[] = ['name' => $key, 'name_es' => $value];
        }

        // this is a handy shortcut
        $this->insert('categories', $rows);
    }

    public function down()
    {
        $this->execute('TRUNCATE table categories');
    }
}
