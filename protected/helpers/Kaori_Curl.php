<?php
/**
 * Curl helper
 * 
 * curl is required
 */
class Kaori_Curl
{
    /**
     * 执行一个 HTTP 请求
     *
     * @param string 	$url 	执行请求的URL 不需协议，只需服务器名和路径，例子 : api.sina.com/oauth2/access_token
     * @param mixed	$params 表单参数
     * 							可以是array, 也可以是经过url编码之后的string
     * @param mixed	$cookie cookie参数
     * 							可以是array, 也可以是经过拼接的string
     * @param string	$method 请求方法 post / get
     * @param string	$protocol http协议类型 http / https
     * @return array 结果数组
     */
    public static function makeRequest($url, $params = array(), $cookie = array(), $method = 'post', $protocol = 'http')
    {
        $url = $protocol . '://' . $url;
        $query_string = self::makeQueryString($params);
        $cookie_string = self::makeCookieString($cookie);

        $ch = curl_init();

        if ('GET' == strtoupper($method))
        {
            curl_setopt($ch, CURLOPT_URL, "$url?$query_string");
        }
        else
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
        }

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

        // disable 100-continue
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        if (!empty($cookie_string))
        {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie_string);
        }

        if ('https' == $protocol)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $ret = curl_exec($ch);
        $err = curl_error($ch);

        if (false === $ret || !empty($err))
        {
            $errno = curl_errno($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            return array(
                'result' => false,
                'errno' => $errno,
                'msg' => $err,
                'info' => $info,
            );
        }

        curl_close($ch);

        return array(
            'result' => true,
            'msg' => $ret,
        );
    }

    /**
     * 执行一个 HTTP 请求,以post方式，multipart/form-data的编码类型上传文件
     *
     * @param string 	$url 	执行请求的URL
     * @param mixed	$params 表单参数，必须是array, 对于文件表单项 直接传递文件的全路径, 并在前面增加'@'符号
     *                          举例: array('upload_file'=>'@/home/xxx/hello.jpg', 'field1'=>'value1');
     * @param mixed	$cookie cookie参数
     * 							可以是array, 也可以是经过拼接的string
     * @param string	$protocol http协议类型 http / https
     * @return array 结果数组
     */
    static public function makeRequestWithFile($url, $params, $cookie, $protocol = 'http')
    {
        $cookie_string = self::makeCookieString($cookie);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

        // disable 100-continue
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        if (!empty($cookie_string))
        {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie_string);
        }

        if ('https' == $protocol)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $ret = curl_exec($ch);
        $err = curl_error($ch);

        if (false === $ret || !empty($err))
        {
            $errno = curl_errno($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            return array(
                'result' => false,
                'errno' => $errno,
                'msg' => $err,
                'info' => $info,
            );
        }

        curl_close($ch);

        return array(
            'result' => true,
            'msg' => $ret,
        );
    }

    static public function makeQueryString($params)
    {
        if (is_string($params))
            return $params;

        $query_string_array = array();
        foreach ($params as $key => $value)
        {
            array_push($query_string_array, rawurlencode($key) . '=' . rawurlencode($value));
        }
        return join('&', $query_string_array);
    }

    static public function makeCookieString($params)
    {
        if (is_string($params))
            return $params;

        $cookie_string_array = array();
        foreach ($params as $key => $value)
        {
            array_push($cookie_string_array, $key . '=' . $value);
        }
        return join('; ', $cookie_string_array);
    }
    
    /**
     * Make an URL with params
     * 
     * @param array $params
     * @param string $serverName
     * @param string $dir
     * @param string $protocol
     * @return string
     */
    public static function makeUrl($params, $serverName, $dir, $protocol = 'http')
    {
        return $protocol . '://' . $serverName . $dir . '?' . self::makeQueryString($params);
    }

    static public function buildForm($uri, $params = array(), $method = 'GET', $buttonName = '跳转')
    {
        $sHtml = "<form id='authLoginRedirForm' name='authLoginRedirForm' action='" . $uri . "' method='" . $method . "'>";
        foreach ($params as $key => $val)
        {
            $sHtml.= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml .= "<input type='submit' value='" . $buttonName . "' style='display:none;'></form>";

        $sHtml = $sHtml . "<script>document.forms['authLoginRedirForm'].submit();</script>";

        return $sHtml;
    }

    /**
     * build a html string to redirect
     * 
     * @param string $uri
     * @param string $linkName
     * @return string
     */
    public static function buildRedirLink($uri, $linkName)
    {
        $html = "<script>window.location='$uri'</script>";
        $html .= "<a href=\"$uri\">$linkName</a>";
        return $html;
    }
}