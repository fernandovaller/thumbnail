<?php

namespace FVCode\Thumbnail\Services;

class Vimeo
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
     * @var array
     */
    private $data;

    public function __construct($url, $config = [])
    {
        $this->url = $url;
        $this->config = $config;

        $this->data = $this->requestAPI();

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
        return isset($this->data['video_id']) ? $this->data['video_id'] : null;
    }

    /**
     * Retorna a url do thumbnail
     *
     * @return string URL
     */
    private function getThumbnail()
    {
        return isset($this->data['thumbnail_url']) ? $this->data['thumbnail_url'] : null;
    }

    private function requestAPI()
    {
        $options = [];

        if (!empty($this->config['origin'])) {
            $options['headers']['Origin'] = $this->config['origin'];
            $options['headers']['Referer'] = $this->config['origin'];
        }

        $client = new \GuzzleHttp\Client($options);

        $response = $client->request('GET', "//vimeo.com/api/oembed.json?url={$this->url}");

        $json = $response->getBody();

        return json_decode($json, true);
    }
}
