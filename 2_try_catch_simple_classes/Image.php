<?php


class Image
{
    private $image;
    private $x;
    private $y;
    private $new_x;
    private $new_y;
    const RatioAccuracy = 3;
    private $exceptions = [];

    public function __construct($filePath, $new_x,  $new_y)
    {
        try {
            $this->image = new Imagick($filePath);
            $imageResolution = $this->image->getImageGeometry();
            $this->x = $imageResolution['width'];
            $this->y = $imageResolution['height'];
//            var_dump($filePath);
//            var_dump($this->x);
//            var_dump($this->y);
            if (($new_x) && (($new_y))) {
                $this->resize($new_x,  $new_y);
            } else throw new \Exception("Zero dimensions obtained from image");
        } catch (\Exception $e) {
            $this->exceptions = [
                'type' => 'danger',
                'message' => $e->getMessage()
            ];
        }

//        var_dump('constructed');
        var_dump($this->exceptions);
    }

    protected function checkRatio($newX, $newY)
    {
        $deltaRes = $newX/$newY - $this->x/$this->y;

        if (abs($deltaRes) > self::RatioAccuracy) {
            throw new Exception("The desirable size ratio is not matches the accuracy");
        }
    }



    public function resize($new_x, $new_y){
        $this->checkRatio($new_x, $new_y);
        $this->image->resizeImage($new_x, $new_y, Imagick::FILTER_CATROM, 0);
        header("Content-Type: image/png");
        echo $this->image->getImageBlob();
//        die('ready');
    }
}