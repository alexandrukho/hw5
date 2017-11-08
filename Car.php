<?php
trait Transmission
{
    public function transmission($param)
    {
        switch ($param) {
            case "on":
                echo "transmission status: ON <br>";
                $res = $this->speed >= 20 ? "gear status: 2" : "gear status 1";
                echo $res . "<br>";
                break;
            case "backward":
                echo "transmission turn BACKWARD <br>";
                break;
            case "off":
                $res = "transmission status OFF <br>";
                echo $res;
        }
    }
}

class Car
{
    use Transmission;
    protected $engine_power;
    private $distance;
    private $speed;
    private $move_to;
    public function __construct($engine_power)
    {
        $this->engine_power = $engine_power;
    }

    public function move($distance, $speed, $move_to)
    {
        $move_to = ($move_to === 1 ? "move" : "backward");
        $this->distance = $distance;
        $this->speed = $speed;
        $this->move_to = $move_to;
        //move car
        $this->engine("on");
        $this->transmission("on");
        $this->engine($move_to, $this->distance, $this->speed);
        $this->transmission("off");
        $this->engine("off");
    }

    protected function engine($status, $distance = null, $speed = null)
    {
        ($this->engine_power * 2 < $speed ? $speed = $this->engine_power * 2 : null);
        $status = strtolower($status);
        switch ($status) {
            case "on":
                echo "engine status: ON<br>";
                break;
            case "move":
                $temperature = 0;
                for ($path = 0; $path < $distance; $path += 10) {
                    $temperature += 5;
                    if ($temperature == 90) {
                        $temperature = $this->cooler($temperature);
                    }
                }
                break;
            case "off":
                echo "engine status: OFF <br>";
                break;
        }
    }

    protected function cooler($tepmerature)
    {
        $tepmerature -= 10;
        return $tepmerature;
    }
}

class Opel extends Car
{
    public function __construct($engine_power)
    {
        parent::__construct($engine_power);
    }
}

class Honda extends Car
{
    public function __construct($engine_power)
    {
        parent::__construct($engine_power);
    }
}

$opel = new Opel(10);
$honda = new Honda(20);
$opel->move(500, 50, 1);
echo "<hr>";
$honda->move(300, 10, 1);
