<?php namespace App\SupportedApps\NextDNS;

class NextDNS extends \App\SupportedApps implements \App\EnhancedApps {

    public $config;

    //protected $login_first = true; // Uncomment if api requests need to be authed first
    //protected $method = 'POST';  // Uncomment if requests to the API should be set by POST
    //

    public function getRequestAttrs()
    {
        $api_key = $this->getConfigValue("api_key", null);
        $attrs["headers"] = [
            "X-Api-Key" => $api_key,
        ];

        return $attrs;
    }

    public function findObjectByStatusInArray($array, $key)
    {
        $result = null;
        foreach ($array as $object) {
            if ($object->status === $key) {
                $result = $object;
            }
        }
        unset($object);
        return $result;
    }

    function __construct() {
        //$this->jar = new \GuzzleHttp\Cookie\CookieJar; // Uncomment if cookies need to be set
    }

    public function test()
    {
        $attrs = $this->getRequestAttrs();
        $path = "profiles/" . $this->getConfigValue("profile", null);
        $test = parent::appTest($this->url($path), $attrs);
        echo $test->status;
    }

    public function livestats()
    {
        $attrs = $this->getRequestAttrs();
        $status = 'active';
        $path = "profiles/" . $this->getConfigValue("profile", null) . "/analytics/status";

        $res = parent::execute($this->url($path), $attrs);
        $details = json_decode($res->getBody());
        
        $data = [];

        if ($details) {
            $default_count = findObjectByStatusInArray($details->data, "default");
            $relayed_count = findObjectByStatusInArray($details->data, "relayed");
            $blocked_count = findObjectByStatusInArray($details->data, "blocked");
            $data["total"] = $default_count;
            $data["blocked_pct"] = ($blocked_count / ($blocked_count + $default_count)) * 100
        }
        return parent::getLiveStats($status, $data);
        
    }
    public function url($endpoint)
    {
        return "https://api.nextdns.io";
    }
}
