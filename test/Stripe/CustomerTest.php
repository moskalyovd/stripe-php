<?php

class Stripe_CustomerTest extends UnitTestCase {
  public function testDeletion() {
    authorizeFromEnv();
    $c = Stripe_Customer::create(array('amount' => 100,
				       'currency' => 'usd',
				       'card' => array('number' => '4242424242424242',
						       'exp_month' => 5,
						       'exp_year' => 2015)));
    $c->delete();
    $this->assertTrue($c->deleted);
    $this->assertNull($c['active_card']);
  }

  public function testSave() {
    authorizeFromEnv();
    $c = Stripe_Customer::create();
    $c->email = 'gdb@stripe.com';
    $c->bogus = 'bogus';
    $c->save();
    $this->assertEqual($c->email, 'gdb@stripe.com');
    $this->assertNull($c['bogus']);

    $c2 = Stripe_Customer::retrieve($c->id);
    $this->assertEqual($c->email, $c2->email);
  }
}
