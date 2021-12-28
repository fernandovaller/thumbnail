<?php

namespace FVCode\Thumbnail;

class Thumbnail
{
    private $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * Validar url informada
     *
     * @param string $url
     * @return Exception
     */
    private function validate($url)
    {
        if (empty($url)) {
            throw new \Exception("URL not informed", 1);
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            throw new \Exception("URL not valid", 1);
        }
    }

    /**
     * Determinado o serviço a ser chamado pela url
     *
     * @param string $url
     * @return object
     */
    private function getService($url)
    {
        $result = parse_url($url);
        $remove = ['www.', '.com', '/'];

        $service = str_replace($remove, '', $result['host']);

        $class = __NAMESPACE__ . '\\Services\\' . ucfirst($service);

        if (!class_exists($class)) {
            throw new \Exception("Service not implemented", 1);
        }

        return new $class($url, $this->config);
    }

    /**
     * Retorna os dados do video
     *
     * @param string $url
     * @return string
     */
    public function get($url)
    {
        // Validações
        $this->validate($url);

        return $this->getService($url)->info();
    }

    /**
     * Retorna os dados do video usando o serviço Noembed.com
     *
     * @param string $url
     * @return array
     */
    public function getNoembed($url)
    {
        // Validações
        $this->validate($url);

        $json = file_get_contents("http://noembed.com/embed?url={$url}");

        return json_decode($json, true);
    }
}
