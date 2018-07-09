<?php
/*
 * 使用openssl实现RSA非对称加密
 *
 * @version $Id: Rsa.php 2812 2014-08-14 08:20:19 $
 */

class Rsa
{
    /**
     * 私钥
     *
     * @var string
     */    
    private $_privateKey = '';

    /**
     * 公钥
     *
     * @var string
     */
    private $_publicKey = '';


    /**
     * 设置私钥路径
     *
     * @param  string $privateKeyPath 私钥路径
     * @param  string $passphrase       私钥密码
     * @return void
     */
    public function setPrivateKeyPath($privateKeyPath, $passphrase = '')
    {
        $privateKey = file_get_contents($privateKeyPath);

        $this->setPrivateKey($privateKey, $passphrase);
    }

    /**
     * 设置公钥路径
     *
     * @param  string $pubicKeyPath 公钥路径
     * @return void
     */
    public function setPublicKeyPath($pubicKeyPath)
    {
        $publicKey = file_get_contents($pubicKeyPath);

        $this->setPublicKey($publicKey);
    }

    /**
     * 设置私钥
     *
     * 注意：PHP使用的是RSA原始私钥而不是PKCS8格式的私钥
     *
     * @param  string $privateKey 私钥
     * @param  string $passphrase 私钥密码
     * @return void
     */
    public function setPrivateKey($privateKey, $passphrase = '')
    {
        if (strpos($privateKey, 'BEGIN RSA PRIVATE KEY') === FALSE)
        {
            $privateKey = chunk_split($privateKey, 64, "\n");
            $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . $privateKey . "-----END RSA PRIVATE KEY-----\n";
        }

        $this->_privateKey = openssl_pkey_get_private($privateKey, $passphrase);
    }
    
    /**
     * 设置公钥
     *
     * @param  string $publicKey 公钥
     * @return void
     */
    public function setPublicKey($publicKey)
    {
        if (strpos($publicKey, 'BEGIN PUBLIC KEY') === FALSE)
        {
            $publicKey = chunk_split($publicKey, 64, "\n");
            $publicKey = "-----BEGIN PUBLIC KEY-----\n" . $publicKey . "-----END PUBLIC KEY-----\n";
        }

        $this->_publicKey = openssl_pkey_get_public($publicKey);
    }
    
    /**
     * 私钥加密字符串
     *
     * @param  string  $string  待加密的字符串
     * @param  integer $padding 填充方式
     * @return string
     */
    public function privateEncrypt($string, $padding = OPENSSL_PKCS1_PADDING)
    {
        $crypted = '';
        $result  = openssl_private_encrypt($string, $crypted, $this->_privateKey, $padding);
        if ($result)
        {
            $crypted = base64_encode($crypted);
        }

        return $crypted;
    }
    
    /**
     * 公钥解密私钥加密的字符串
     *
     * @param  string  $crypted 待解密的字符串
     * @param  integer $padding 填充方式
     * @return string
     */
    public function publicDecrypt($crypted, $padding = OPENSSL_PKCS1_PADDING)
    {
        $decrypted = '';
        $crypted   = base64_decode($crypted);
        $result    = openssl_public_decrypt($crypted, $decrypted, $this->_publicKey, $padding);

        return $decrypted;
    }
    
    /**
     * 公钥加密字符串
     * 
     * @param  string  $string 待加密的字符串
     * @param  integer $padding 填充方式
     * @return string
     */
    public function publicEncrypt($string, $padding = OPENSSL_PKCS1_PADDING)
    {
        $crypted = '';
        $result  = openssl_public_encrypt($string, $crypted, $this->_publicKey, $padding);
        if ($result)
        {
            $crypted = base64_encode($crypted);
        }

        return $crypted;
    }

    /**
     * 私钥解密公钥加密的字符串
     *
     * @param  string  $crypted 待解密的字符串
     * @param  integer $padding 填充方式
     * @return string
     */
    public function privateDecrypt($crypted, $padding = OPENSSL_PKCS1_PADDING)
    {
        $decrypted = '';
        $crypted   = base64_decode($crypted);
        $result    = openssl_private_decrypt($crypted, $decrypted, $this->_privateKey, $padding);

        return $decrypted;
    }
    
    /**
     * 私钥签名
     * 
     * @param  string  $string 待签名的字符串
     * @param  integer $algo   签名算法
     * @return string
     */
    public function sign($string, $algo = OPENSSL_ALGO_SHA1)
    {
        $signature = '';

        $result = openssl_sign($string, $signature, $this->_privateKey, $algo);
        if ($result)
        {
            $signature = base64_encode($signature);
        }

        return $signature;
    }
    
    /**
     * 公钥验证签名
     * 
     * @param  string  $string       待验证的字符串
     * @param  string  $signature 字符串的签名
     * @param  integer $algo         签名算法
     * @return boolean
     */
    public function verify($string, $signature, $algo = OPENSSL_ALGO_SHA1)
    {
        $signature = base64_decode($signature);
        $result    = openssl_verify($string, $signature, $this->_publicKey, $algo);

        // 1=正确 0=不正确 -1=错误
        if ($result == 1)
        {
            return TRUE;
        }

        return FALSE;
    }
    
    /**
     * 在析构函数中释放资源
     */
    public function __destruct()
    {
        if (is_resource($this->_privateKey))
        {
            openssl_free_key($this->_privateKey);
        }

        if (is_resource($this->_publicKey))
        {
            openssl_free_key($this->_publicKey);
        }
    }
}
?>