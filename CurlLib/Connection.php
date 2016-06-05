<?php

namespace Redstar\AgileCRM;

class Connection
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $userEmail;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * Connect to AgileCRM
     * @param string $domain
     * @param string $userEmail
     * @param string $apiKey
     */
    public function __construct($domain, $userEmail, $apiKey)
    {
        $this->domain = $domain;
        $this->userEmail = $userEmail;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $entity
     * @param string $data
     * @param string $method
     * @param string $content_type
     * @return string
     */
    public function makeRequest($entity, $data, $method, $content_type)
    {
        if ($content_type == NULL) {
            $content_type = "application/json";
        }

        $agile_url = "https://" . $this->domain . ".agilecrm.com/dev/api/" . $entity;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
        switch ($method) {
            case "POST":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "GET":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case "PUT":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                break;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-type : $content_type;", 'Accept : application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->userEmail . ':' . $this->apiKey);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
