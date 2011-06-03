<?php

class Stripe_Customer extends Stripe_ApiResource {
  public static function constructFrom($values, $apiKey=null) {
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiKey);
  }

  public static function retrieve($id, $apiKey=null) {
    $class = get_class();
    return self::scopedRetrieve($class, $id, $apiKey);
  }

  public static function all($params=null, $apiKey=null) {
    $class = get_class();
    return self::scopedAll($class, $params, $apiKey);
  }

  public static function create($params=null, $apiKey=null) {
    $class = get_class();
    return self::scopedCreate($class, $params, $apiKey);
  }

  public function save() {
    $class = get_class();
    return self::scopedSave($class);
  }

  public function delete() {
    $class = get_class();
    return self::scopedDelete($class);
  }

  public function addInvoiceItem($params=null) {
    if (!$params)
      $params = array();
    $params['customer'] = $this->id;
    $ii = Stripe_InvoiceItem::create($params, $this->apiKey);
    return $ii;
  }

  public function invoices($params=null) {
    if (!$params)
      $params = array();
    $params['customer'] = $this->id;
    $invoices = Stripe_Invoice::all($params, $this->apiKey);
    return $invoices;
  }

  public function invoiceItems($params=null) {
    if (!$params)
      $params = array();
    $params['customer'] = $this->id;
    $iis = Stripe_InvoiceItem::all($params, $this->apiKey);
    return $iis;
  }

  public function charges($params=null) {
    if (!$params)
      $params = array();
    $params['customer'] = $this->id;
    $charges = Stripe_Charge::all($params, $this->apiKey);
    return $charges;
  }

  public function updateSubscription($params=null) {
    $requestor = new Stripe_ApiRequestor($this->apiKey);
    $url = $this->instanceUrl() . '/subscription';
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    $this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $this->subscription;
  }

  public function cancelSubscription() {
    $requestor = Stripe_ApiRequestor($this->apiKey);
    $url = $this->instanceUrl() . '/subscription';
    list($response, $apiKey) = $requestor->request('delete', $url);
    $this->refreshFrom(array('subscription' => $response), $apiKey, true);
    return $this->subscription;
  }
}
