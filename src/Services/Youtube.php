<?php

namespace FVCode\Thumbnail\Services;

class Youtube
{
    /**
     * URL do vídeo
     *
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $id;

    /**
     * URL do thumbnail
     *
     * @var string
     */
    private $thumbnail;

    /**
     * @var array
     */
    private $config;

    /**
     * Qualidade da resolução do thumbnail
     *
     * @var array
     */
    const QUALITY = [
        'default' => 'default',
        'high' => 'hqdefault',
        'medium' => 'mqdefault',
        'standard' => 'sddefault',
        'maximum' => 'maxresdefault',
    ];

    /**
     * Padrão para pegar o ID da url
     *
     * @var string
     */
    const PATTERN = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i';

    public function __construct($url, $config = [])
    {
        $this->url = $url;
        $this->config = $config;

        $this->id = $this->getID();
        $this->thumbnail = $this->getThumbnail();
    }

    public function info()
    {
        return [
            'id' => $this->id,
            'thumbnail' => $this->thumbnail
        ];
    }

    /**
     * Retorna o id extraido do url informada
     *
     * @return string ID do vídeo
     */
    private function getID()
    {
        if (preg_match(self::PATTERN, $this->url, $match)) {

            if (empty($match[1])) {
                throw new \Exception("Error get ID in URL", 1);
            }

            return $match[1];
        }
    }

    /**
     * Retorna a url do thumbnail
     *
     * @param string $id
     * @return string URL
     */
    private function getThumbnail()
    {
        $quality = self::QUALITY['default'];

        if (isset($this->config['quality'])) {
            if (!empty(self::QUALITY[$this->config['quality']])) {
                $quality = self::QUALITY[$this->config['quality']];
            }
        }

        return "https://img.youtube.com/vi/{$this->id}/{$quality}.jpg";
    }
}
