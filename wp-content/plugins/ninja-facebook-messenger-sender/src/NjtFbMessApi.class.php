<?php
if (!defined('ABSPATH')) {
    exit;
}
class NjtFbMessApi
{
    private $app_id;
    private $app_secret;
    private $user_token;
    private $ver = 'v2.8';

    public $fb_var;

    public function __construct()
    {
        $this->app_id = get_option('njt_fb_mess_fb_app_id', false);
        $this->app_secret = get_option('njt_fb_mess_fb_app_secret', false);
        $this->user_token = get_option('njt_fb_mess_fb_user_token', false);

        $this->fbVar();
    }

    private function fbVar()
    {
        if ($this->app_id != false && $this->app_secret != false) {
            return $this->fb_var = new Facebook\Facebook(array(
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
                'default_graph_version' => $this->ver,
            ));
        }
    }
    public function codeToToken($code, $redirect_uri)
    {

        $url = sprintf('https://graph.facebook.com/%5$s/oauth/access_token?client_id=%1$s&redirect_uri=%2$s&client_secret=%3$s&code=%4$s', $this->app_id, $redirect_uri, $this->app_secret, $code, $this->ver);
        $request = $this->cURL($url);
        $request = json_decode($request);
        return ((isset($request->access_token)) ? $request->access_token : $request);

    }
    public function generateLoginUrl($redirect_uri, $permissions = array())
    {
        if (empty($permissions)) {
            $permissions = array('email', 'manage_pages', 'public_profile', 'pages_messaging');
        }

        $helper = $this->fb_var->getRedirectLoginHelper();

        return $helper->getLoginUrl($redirect_uri, $permissions);
    }
    public function getAllPages()
    {
        // $json = $this->cURL('https://graph.facebook.com/v2.8/me/accounts?access_token=' . $this->user_token . '&limit=10000');
        // $json = json_decode($json);
        // $pages = [];
        // foreach ($json->data as $k => $page) {
        //     $pages[] = array(
        //         'category' => $page->category,
        //         'name' => $page->name,
        //         'id' => $page->id,
        //         'access_token' => $page->access_token,
        //     );
        // }
        // return $pages;
        $json = $this->cURL('https://graph.facebook.com/v2.8/me?fields=id,name,accounts.limit(50){access_token,is_published,name,id,category}&access_token=' . $this->user_token);
        $json = json_decode($json);
        if (isset($json->error->message)) {
            return $json->error->message;
        } else {
            $all_pages = isset($json->accounts->data) ? $json->accounts->data : array();
            $next_pages = isset($json->accounts->paging->next) ? $json->accounts->paging->next : false;
            $pages = [];
            $count = 0;
            do {
                if ($next_pages && $count > 0) {
                    $json = $this->cURL($next_pages);
                    $json = json_decode($json);
                    $all_pages = isset($json->data) ? $json->data : array();
                    $next_pages = isset($json->paging->next) ? $json->paging->next : false;
                }
                foreach ($all_pages as $k => $page) {
                    $pages[] = array(
                        'category' => $page->category,
                        'name' => $page->name,
                        'id' => $page->id,
                        'access_token' => $page->access_token,
                        // 'is_published' => $page->is_published ? 1 : 0,
                    );
                }
                $count++;
            } while ($next_pages);

            return $pages;

        }
    }
    public function getAppAccessToken()
    {
        $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $this->app_id . "&client_secret=" . $this->app_secret . "&grant_type=client_credentials";
        $app_token = $this->cURL($token_url);
        $app_token = json_decode($app_token);
        return (isset($app_token->access_token) ? $app_token->access_token : '');
    }

    public function subscribeAppToPage($page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/me/subscribed_apps';
        $post = [
            "subscribed_fields" => array("messaging_postbacks", "messaging_optins", "messages", "message_deliveries", "message_reads", "messaging_referrals", "feed"),
            'access_token' => $page_token,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : true);
    }
    public function deleteSubscribe($page_id, $page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/' . $page_id . '/subscribed_apps';
        $data = 'access_token=' . $page_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return $result;
    }
    /*
     * create new Webhooks subscriptions
     * @var $token string: app access token
     */
    public function addPageWebhooks($callback_url)
    {
        $url = "https://graph.facebook.com/" . $this->ver . "/" . $this->app_id . "/subscriptions";
        $fields = 'message_deliveries, messages, messaging_optins, messaging_postbacks, messaging_referrals';
        $fields = urlencode($fields);
        $post = "access_token=" . $this->getAppAccessToken() . "&object=page&callback_url=" . $callback_url . "&fields=" . $fields . "&verify_token=" . get_option('njt_fb_mess_fb_verify_token');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);
        return $str;
    }

    /*
     * Delete page subscriptions using this operation:
     */
    public function deletePageWebhooks()
    {
        global $app_id, $app_secret;

        $url = 'https://graph.facebook.com/' . $this->ver . '/' . $this->app_id . '/subscriptions';
        $post = "access_token=" . $this->getAppAccessToken() . "&object=page";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    public function sendMessenger($to, $message, $page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/me/messages?access_token=' . $page_token;
        $post = json_encode(array(
            'recipient' => array('id' => $to),
            'message' => $message,
        ));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post),
        )
        );
        $result = curl_exec($ch);
        $result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : 'sent');
    }
    public function getUserInfo($sender_id, $page_token)
    {

        //$url = 'https://graph.facebook.com/'.$this->ver.'/'.$sender_id.'?access_token='.$page_token.'&format=json';
        // $url = 'https://graph.facebook.com/' . $this->ver . '/' . $sender_id . '?fields=first_name,last_name,profile_pic,gender,locale,timezone&access_token=' . $page_token . '&format=json';
        $url = 'https://graph.facebook.com/' . $this->ver . '/' . $sender_id . '?fields=first_name,last_name,profile_pic&access_token=' . $page_token . '&format=json';
        $info = $this->cURL($url);
        return json_decode($info);
    }

    public function getPageConversations($args = array())
    {
        $defaults = array('page_id' => null, 'page_token' => null, 'url' => null);
        $args = wp_parse_args($args, $defaults);
        extract($args);
        if (is_null($url)) {
            $url = "https://graph.facebook.com/" . $this->ver . "/" . $page_id . "/conversations?access_token=" . $page_token;
        }
        $request = $this->cURL($url);
        return json_decode($request);
    }

    public function replyConversation($conversation_id, $page_token, $mess)
    {
        $url = "https://graph.facebook.com/" . $this->ver . "/" . $conversation_id . "/messages";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'message=' . $mess . '&access_token=' . $page_token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);

    }
    public function cURL($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        curl_close($ch);

        return $return;
    }
}
