<?php

namespace Agile;

use PHPUnit_Framework_TestCase;

class ConnectionTest extends PHPUnit_Framework_TestCase
{
    const DOMAIN = 'redstarmedia';
    const EMAIL = 'brayden@redstarmedia.ca';
    const API_KEY = 'uae0u5cbaaqqjlorj9pd4jtrmq';

    public function testMakeRequest()
    {
        $connection = new Connection(self::DOMAIN, self::EMAIL, self::API_KEY);

        $contact_json = array(
            "tags" => array("Test"),
            "properties" => array(
                array(
                    "name" => "first_name",
                    "value" => "Michael",
                    "type" => "SYSTEM"
                ),
                array(
                    "name" => "last_name",
                    "value" => "Burton",
                    "type" => "SYSTEM"
                ),
                array(
                    "name" => "email",
                    "value" => "m.burton.".time()."@example.com",
                    "type" => "SYSTEM"
                ),
            )
        );

        $contact_json_input = json_encode($contact_json);
        $response = $connection->makeRequest("contacts", $contact_json_input, "POST", "application/json");

        $this->assertArrayHasKey('id', json_decode($response, true));
    }
}
