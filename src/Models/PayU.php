<?php

/**
 * Part of the PayU package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    PayU
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente
 */

namespace Jlorente\Laravel\PayU\Models;

use Illuminate\Support\Str;
use Jlorente\PayU\PayU as PayUConfig;
use Jlorente\PayU\PayU\api\Environment;
use Jlorente\PayU\PayU\api\SupportedLanguages;
use ReflectionClass;

class PayU
{

    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     *
     * @var string 
     */
    protected $apiKey;

    /**
     *
     * @var string 
     */
    protected $apiLogin;

    /**
     *
     * @var string 
     */
    protected $merchantId;

    /**
     *
     * @var string 
     */
    protected $language = SupportedLanguages::ES;

    /**
     *
     * @var bool 
     */
    protected $isTest = false;

    /**
     * Constructs a new PayU instance.
     * 
     * @param string $apiKey
     * @param string $apiLogin
     * @param string $merchantId
     * @param string $language
     * @param bool $isTest
     * @return \static
     */
    public function __construct(
            $apiKey
            , $apiLogin
            , $merchantId
            , $language = SupportedLanguages::ES
            , $isTest = false
    )
    {
        $this->setApiKey($apiKey);
        $this->setApiLogin($apiLogin);
        $this->apiKey = $apiKey;
        $this->apiLogin = $apiLogin;
        $this->merchantId = $merchantId;
        $this->language = $language;
        $this->isTest = $isTest;
    }

    /**
     * Creates a new PayU instance.
     * 
     * @param string $apiKey
     * @param string $apiLogin
     * @param string $merchantId
     * @param string $language
     * @param bool $isTest
     * @return \static
     */
    public static function make(
            $apiKey
            , $apiLogin
            , $merchantId
            , $language = SupportedLanguages::ES
            , $isTest = false
    )
    {
        return new static(
                $apiKey
                , $apiLogin
                , $merchantId
                , $language
                , $isTest
        );
    }

    /**
     * Ensures the PayU client SDK configuration.
     * 
     * @return $this
     */
    public function ensurePayUConfig()
    {
        PayUConfig::$apiKey = $this->apiKey;
        PayUConfig::$apiLogin = $this->apiLogin;
        PayUConfig::$merchantId = $this->merchantId;
        PayUConfig::$language = $this->language;
        PayUConfig::$isTest = $this->isTest;
        Environment::$test = $this->isTest;

        return $this;
    }

    /**
     * Returns the PayU API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets the PayU API key.
     *
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Returns the PayU API login.
     *
     * @return string
     */
    public function getApiLogin()
    {
        return $this->apiLogin;
    }

    /**
     * Sets the PayU API login.
     *
     * @param string $apiLogin
     * @return $this
     */
    public function setApiLogin($apiLogin)
    {
        $this->apiLogin = $apiLogin;

        return $this;
    }

    /**
     * Returns the PayU API merchant ID.
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * Sets the PayU API merchant ID.
     *
     * @param string $merchantId
     * @return $this
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * Returns the PayU API language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets the PayU API language.
     *
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Returns the PayU isTest parameter.
     *
     * @return string
     */
    public function getIsTest()
    {
        return $this->isTest;
    }

    /**
     * Sets the PayU API isTest parameter.
     *
     * @param string $isTest
     * @return $this
     */
    public function setIsTest($isTest)
    {
        $this->isTest = (bool) $isTest;

        return $this;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed A PayU class name to handle static calls.
     */
    public function __call($method, $parameters)
    {
        $this->ensurePayUConfig();

        return $this->getApiInstance($method);
    }

    /**
     * Returns the Api class instance for the given method.
     *
     * @param  string  $method
     * @return \Jlorente\Appsflyer\Api\ApiInterface
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($method)
    {
        $class = "\\Jlorente\\PayU\\PayU\\PayU" . Str::studly($method);

        if (class_exists($class) && !(new ReflectionClass($class))->isAbstract()) {
            return $class;
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }

}
