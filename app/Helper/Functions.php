<?php declare(strict_types = 1);

/**
 * 加密
 *
 * @param        $data
 * @param string $key
 * @param int    $expire
 *
 * @return string|string[]
 */
function think_encrypt($data, $key = '', $expire = 0)
{
    $key  = md5(empty ($key) ? config('app.global_auth_key') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';
    for ($i = 0; $i < $len; $i ++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x ++;
    }
    $str = sprintf('%010d', $expire ? $expire + time() : 0);
    for ($i = 0; $i < $len; $i ++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
    }

    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($str));
}

/**
 * 解密
 *
 * @param        $data
 * @param string $key
 *
 * @return false|string
 */
function think_decrypt($data, $key = '')
{
    $key  = md5(empty ($key) ? config('app.global_auth_key') : $key);
    $data = str_replace(['-', '_', ''], ['+', '/', '='], $data);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data, 0, 10);
    $data   = substr($data, 10);
    if ($expire > 0 && $expire < time()) {
        return '';
    }
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = $str = '';
    for ($i = 0; $i < $len; $i ++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x ++;
    }
    for ($i = 0; $i < $len; $i ++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }

    return base64_decode($str);
}

/**
 * 简单加密
 *
 * @param        $data
 * @param string $key
 * @param int    $expire
 *
 * @return string|string[]
 */
function en($data, $key = '', $expire = 0)
{
    return think_encrypt($data, $key, $expire);
}

/**
 * 简单解密
 *
 * @param        $data
 * @param string $key
 *
 * @return false|int|string
 */
function de($data, $key = '')
{
    if (is_numeric($data)) {
        return $data;
    }
    if (empty($data)) {
        return $data;
    }

    return think_decrypt($data, $key);
}

function authentication(string $token)
{
    if (!$token) {
        return FALSE;
    }

    $token = tokenNormalization($token);
    if (!$token) {
        return FALSE;
    }

    $token = urldecode($token);
    $token = de($token);
    $token = json_decode($token, TRUE);
    if (!$token) {
        return FALSE;
    }

    if (de($token['sign']) !== $token['id'] . $token['account'] . $token['logintime']) {
        return FALSE;
    }

    return $token;
}

function tokenNormalization($token)
{
    //特殊字符串1首次出现的位置
    $slash1Position = strpos($token, '#1');
    //特殊字符串2首次出现的位置
    $slash2Position = strpos($token, '##2');
    if ($slash1Position !== FALSE) {
        //截取特殊字符串1之前的字符串
        $str1 = substr($token, 0, $slash1Position - 2);
        //截取特殊字符串1之后的字符串
        $str2 = substr($token, $slash1Position + 3);
        //拼接
        $token = $str1 . '/' . $str2;
        //递归验证
        $token = tokenNormalization($token);
    }
    if ($slash2Position !== FALSE) {
        //截取特殊字符串2之前的字符串
        $str1 = substr($token, 0, $slash2Position - 1);
        //截取特殊字符串2之后的字符串
        $str2 = substr($token, $slash2Position + 5);
        //拼接
        $token = $str1 . $str2;
        //递归验证
        $token = tokenNormalization($token);
    }

    return $token;
}

function wsReturn($resource = [], $code = 100000)
{
    if (is_numeric($resource)) {
        $data = $code === 100000 ? (object) [] : $code;
        $code = $resource;
    } else {
        $data = is_null($resource) ? (object) [] : $resource;
    }
    $message    = config('errorcode.' . $code);
    $messageStr = !$message ? '错误码未找到，错误码为' . $code : $message;

    if ($code == 100000) {
        $status = 1;
    } else {
        $status = 0;
    }

    $returnData['status']  = $status;
    $returnData['code']    = $code;
    $returnData['message'] = $messageStr;
    $returnData['data']    = $data;

    return $returnData;
}

/**
 * 屏蔽XSS
 *
 * @param $val
 *
 * @return string|string[]|null
 */
function removeXSS($val)
{
    $val    = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i ++) {
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
        $val = preg_replace('/(�{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val);                // with a ;
    }
    $ra1 = ['javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base',];
    $ra2 = ['onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload',];
    $ra  = array_merge($ra1, $ra2);

    $found = TRUE; // keep replacing as long as the previous round replaced something
    while ($found == TRUE) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i ++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j ++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(�{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern     .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
            $val         = preg_replace($pattern, $replacement, $val);         // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = FALSE;
            }
        }
    }

    return $val;
}

/**
 * 获取头像
 *
 * @param int $id
 *
 * @return string
 */
function getAvatar(int $id)
{
    return '/static/png/chat_ex_y.png';
}

/**
 * 获取房间号
 *
 * @param int $uid
 * @param int $friendId
 *
 * @return false|string
 */
function getRoomNumber(int $uid, int $friendId)
{
    if ($uid > $friendId) {
        $str = $friendId . config('app.global_auth_key') . $uid;
    } else {
        $str = $uid . config('app.global_auth_key') . $friendId;
    }

    $roomNum = substr(md5($str), 3, 11);

    return $roomNum;
}
