<?php
trait transmission
{
    function transmission($param)
    {
        $param = strtolower($param);
        switch ($param) {
            case 'on':
                if ($this->move_to == 1) {
                    switch ($this->transmissionType) {
                        case '1':
                            echo "transmission: on<br>";
                            if ($this->speed <= 20 && $this->speed > 0) {
                                echo "gear 1: on<br>";
                            } elseif ($this->speed > 20) {
                                echo "gear 2: on<br>";
                            }
                            break;
                        case '2':
                            echo "auto transmission: on<br>";
                            break;
                    }
                } elseif ($this->move_to == 2) {
                    echo "backward gear: on<br>";
                }
                break;
            case 'off':
                echo "transmission: off<br>";
                break;
        }
    }
}

class Car
{
    use transmission;
    protected $power;
    protected $transmissionType;

    private $speed;
    private $distance;
    private $move_to;

    public function move($distance, $speed, $move_to)
    {
        $this->distance = $distance;
        $this->speed = $speed;
        $this->move_to = $move_to;
        $this->engine('on');
        $this->transmission('on');
        $move_to = ($move_to == 1 ? 'move' : 'reverse');
        $this->engine($move_to, $this->distance, $this->speed);
        $this->transmission('off');
        $this->engine('off');
    }

    protected function engine($status, $distance = null, $speed = null)
    {
        if (($this->power * 2) < $speed) {
            $speed = $this->power * 2;        //определение скорости в зависмости от мощности
        }
        $status = strtolower($status);
        switch ($status) {
            case 'on':
                echo "engine: on<br>";
                break;
            case 'move':
                $temperature = 0;
                for ($path = 0; $path < $distance; $path += 10) {
                    $temperature += 5;
                    if ($temperature === 90) {
                        $temperature = $this->cooler($temperature);
                    }
                }
                break;
            case "reverse":
                break;
            case 'off':
                echo "engine: off<br>";
                break;
        }
    }

    protected function cooler($temperature)
    {
        $temperature -= 10;
        return $temperature;
    }
}

final class Niva extends Car
{
    function __construct($power)
    {
        $this->power = $power;
        $this->transmissionType = 1;
    }
}

final class Lamborgini extends Car
{
    function __construct($power)
    {
        $this->power = $power;
        $this->transmissionType = 2;
    }
}
$car1 = new Niva (10); //параметры (мощность)
$car1->move(300,150, 1); // параметры (дистанция, скорость, направление) 1 - вперед. 2 - назад
echo '<br>';
$car2 = new Lamborgini(100);
$car2->move(600, 50, 1);