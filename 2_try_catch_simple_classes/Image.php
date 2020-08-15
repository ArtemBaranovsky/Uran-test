<?php


class Image
{
    private $image;
    private $x;
    private $y;
    const RatioAccuracy = 3;
    private $exceptions = [];

    public function __construct($filePath)
    {
        try {
            $this->image = new Imagick($filePath);
            list($this->x, $this->y) = $this->image->getImageResolution();
        } catch (\Exception $e) {
            $exceptions = [
                'type' => 'danger',
                'message' => $e->getMessage()
            ];
        }
    }

    protected function checkRatio($newX, $newY)
    {
        $deltaRes = $newX/$newY - $this->x/$this->y;

        if (abs($deltaRes) > RatioAccuracy) {
            throw new Exception("The desirable size ratio is not matches the accuracy");
        }
    }



    public function Resize($x, $y){
        $this->checkRatio($x, $y);
        $this->image->resizeImage($x, $y, Imagick::FILTER_CATROM, 0);
        header("Content-Type: image/png");
        echo $this->image->getImageBlob();
    }
}