<?php

namespace AlxFavela\ConektaPayment;
require_once(__DIR__.'/../../../conekta/conekta-php/lib/Conekta.php');

use \Conekta\Conekta as Conekta;
use \Conekta\Customer as Customer;
use \Conekta\Order as Order;
use \Conekta\ProcessingError as ProcessingError;
use \Conekta\ParameterValidationError as ParameterValidationError;
use \Conekta\Handler as Handler;

class ConektaPayment
{
	public $currency, $paymentSources, $customer, $orderMetaData, $shippingLines;

    function __construct() {
    	Conekta::setApiKey(config('conekta.api_key'));
    	Conekta::setApiVersion(config('conekta.api_version'));
    	Conekta::setLocale(config('conekta.locale'));
    	$this->currency = 'MXN';
    	$this->paymentSources = [];
    	$this->customer = null;
    	$this->orderMetaData = [];
    	$this->shippingLines = [];
    }

    public function setApiKey($key)
    {
    	Conekta::setApiKey($key);
    }

    public function setApiVersion($version)
    {
    	Conekta::setApiVersion($version);
    }

    public function setLocale($locale)
    {
    	Conekta::setLocale($version);
    }

    public function addPaymentSource($paymentSource)
    {
    	array_push($this->paymentSources, $paymentSource);
    }

    public function addShippingLine($shippingLine)
    {
    	array_push($this->shippingLines, $shippingLine);
    }

    public function createCustomer($customerData)
    {
    	try {

    		$this->customer = Customer::create($customerData);

    		return $this->customer;

    	} catch (ProccessingError $error) {
    		dd($error->getMesage());

    	} catch (ParameterValidationError $error) {
    		dd($error->getMessage());

    	} catch (\Conekta\Handler $error) {
    		dd($error->getMessage());
    	}
    }

    public function createOrder($items = [])
    {
    	try {

    		$data = [
    			'line_items' => $items,     			
    			'currency' => $this->currency,
    			'customer_info' => $this->customer, 
    			'metadata' => $this->orderMetaData,
    		];

    		if (!empty($this->shippingLines)) {
    			$data['shipping_lines'] = $this->shippingLines;
    		}

    		$order = Order::create($data);

    		return $order;

    	} catch (ProcessingError $error){
    		dd($error->getMessage());

    	} catch (ParameterValidationError $error){
    		dd($error->getMessage());

    	} catch (Handler $error){
    		dd($error->getMessage());
    	}
    }

    public function findCustomer($id)
    {
    	return Customer::find($id);
    }

    public function findOrder($id)
    {
    	return Order::find($id);
    }

}