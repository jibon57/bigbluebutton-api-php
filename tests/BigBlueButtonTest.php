<?php
/**
 * BigBlueButton open source conferencing system - http://www.bigbluebutton.org/.
 *
 * Copyright (c) 2016 BigBlueButton Inc. and by respective authors (see below).
 *
 * This program is free software; you can redistribute it and/or modify it under the
 * terms of the GNU Lesser General Public License as published by the Free Software
 * Foundation; either version 3.0 of the License, or (at your option) any later
 * version.
 *
 * BigBlueButton is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with BigBlueButton; if not, see <http://www.gnu.org/licenses/>.
 */
namespace BigBlueButton;

class BigBlueButtonTest extends TestCase
{
    /**
     * @var BigBlueButton
     */
    private $bbb;

    public function setUp()
    {
        parent::setUp();

        foreach (['BBB_SECURITY_SALT', 'BBB_SERVER_BASE_URL'] as $k) {
            if (!isset($_SERVER[$k]) || !isset($_SERVER[$k])) {
                $this->fail('$_SERVER[\'' . $k . '\'] not set in '
                    . 'phpunit.xml');
            }
        }

        $this->bbb = new BigBlueButton();
    }

    /* API Version */

    public function testApiVersion()
    {
        $apiVersion = $this->bbb->getApiVersion();
        $this->assertEquals('SUCCESS', $apiVersion->getReturnCode());
        $this->assertEquals('0.9', $apiVersion->getVersion());
    }

    /* Create Meeting */

    public function testCreateMeetingUrl()
    {
        $params = $this->generateCreateParams();
        $url = $this->bbb->getCreateMeetingUrl($this->getCreateParamsMock($params));
        foreach ($params as $key => $value) {
            $this->assertContains('=' . urlencode($value), $url);
        }
    }

    public function testCreateMeeting()
    {
        $params = $this->generateCreateParams();
        $result = $this->bbb->createMeeting($this->getCreateParamsMock($params));
        $this->assertEquals("SUCCESS", $result->getReturnCode());
    }
}
