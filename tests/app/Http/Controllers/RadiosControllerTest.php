<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class RadiosControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string $table Nombre de la tabla. */
    protected $table = 'radios';

    /**
     * Verificar si la ruta radio retorna un objecto.
     * 
     *  @return void
     */
    public function testGetRadioAll()
    {
        $radios = factory('App\Radio', 10)->create();

        $this->get('/radio');
        
        $this->seeStatusCode(200);
        
        foreach ($radios as $radio) {
            $this->seeJson([
                'id'        => $radio->id,
                'name'      => $radio->name,
                'streaming' => $radio->streaming
            ]);
        }
    }

    /**
     * Verificar si la ruta radio retorna un objecto.
     * 
     *  @return void
     */
    public function testPostRadioStore()
    {
        $create = [
            'name'      => 'Nombre Radio',
            'streaming' => 'http://192.168.1.1'
        ];

        $this->post('/radio', $create);

        $this->seeStatusCode(201);

        $this->seeJson($create);

        $this->seeInDatabase($this->table, $create);
    }

    /**
     * Verificar los datos de una radio.
     * 
     *  @return void
     */
    public function testGetRadioShow()
    {
        $radio = factory('App\Radio')->create();
        
        $this->get('/radio/' . $radio->id);

        $this->seeStatusCode(200);

        $this->seeJson([
            'id'        => $radio->id,
            'name'      => $radio->name,
            'streaming' => $radio->streaming
        ]);
    }

    /**
     * Actualizar los datos de una radio.
     * 
     *  @return void
     */
    public function testPutRadioUpdate()
    {   
        $update = [
            'name'      => 'Nombre Radio 2',
            'streaming' => 'http://192.168.1.2'
        ];
        $radio = factory('App\Radio')->create();
        
        $this->put('/radio/' . $radio->id, $update);

        $this->seeJson($update);

        $this->seeInDatabase($this->table, $update);
    }

    /**
     * Actualizar los datos de una radio.
     * 
     *  @return void
     */
    public function testDeleteRadioDestroy()
    {
        $radio = factory('App\Radio')->create();
        
        $this->delete('/radio/' . $radio->id);

        $this->seeStatusCode(204);

        $this->seeJson(['deleted']);
        
        $this->isEmpty();
        
        $this->notSeeInDatabase($this->table, ['id' => $radio->id]);
    }
}