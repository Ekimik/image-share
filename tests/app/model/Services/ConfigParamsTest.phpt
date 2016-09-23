<?php

require '../../../bootstrap.php';

use \Tester\Assert,
    \Tester\TestCase,
    \App\Model\Services\ConfigParams;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class ConfigParamsTest extends TestCase {

    /**
     * @covers ConfigParams::setParams
     */
    public function testSetParams() {
        $cfgParams = new ConfigParams();
        $cfgParams->setParams(['appName' => 'Foo', 'appYear' => 'Bar']);
        Assert::equal('Foo', $cfgParams->get('appName'));
        Assert::equal('Bar', $cfgParams->get('appYear'));

        try {
            $cfgParams = new ConfigParams();
            $cfgParams->setParams(['fooParam' => 'barValue']);
            Assert::fail('Exception expected, but nothing happens');
        } catch (Exception $e) {
            // correct
        }
    }

    /**
     * @covers ConfigParams::isParamConfigured
     */
    public function testIsParamConfigured() {
        $cfgParams = new ConfigParams();
        Assert::false($cfgParams->isParamConfigured('appName'));
        Assert::false($cfgParams->isParamConfigured('appYear'));
        Assert::false($cfgParams->isParamConfigured('eventDate'));

        $cfgParams->setParams(['appName' => 'Foo', 'appYear' => 'Bar']);
        Assert::true($cfgParams->isParamConfigured('appName'));
        Assert::true($cfgParams->isParamConfigured('appYear'));
        Assert::false($cfgParams->isParamConfigured('eventDate'));

        try {
            $cfgParams->isParamConfigured('fooParam');
            Assert::fail('Exception expected, but nothing happens');
        } catch (Exception $e) {
            // correct
        }
    }

    /**
     * @covers ConfigParams::isAppRunPeriodValid
     */
    public function testIsAppValid() {
        // unlimited app
        $cfgParams = new ConfigParams();
        Assert::true($cfgParams->isAppRunPeriodValid());

        $cfgParams->setParams(['appValidFrom' => date('Y-m-d H:i:s', time() - 1000), 'appValidTo' => date('Y-m-d H:i:s', time() + 1000)]);
        Assert::true($cfgParams->isAppRunPeriodValid());

        $cfgParams->setParams(['appValidFrom' => date('Y-m-d H:i:s', time() - 1000), 'appValidTo' => date('Y-m-d H:i:s', time() - 10)]);
        Assert::false($cfgParams->isAppRunPeriodValid());

        $cfgParams->setParams(['appValidFrom' => NULL, 'appValidTo' => date('Y-m-d H:i:s', time() - 10)]);
        Assert::false($cfgParams->isAppRunPeriodValid());

        $cfgParams->setParams(['appValidFrom' => NULL, 'appValidTo' => date('Y-m-d H:i:s', time() + 10)]);
        Assert::true($cfgParams->isAppRunPeriodValid());

        $cfgParams->setParams(['appValidFrom' => date('Y-m-d H:i:s'), 'appValidTo' => date('Y-m-d H:i:s')]);
        Assert::true($cfgParams->isAppRunPeriodValid());

        $cfgParams->setParams(['appValidFrom' => date('Y-m-d'), 'appValidTo' => date('Y-m-d')]);
        Assert::true($cfgParams->isAppRunPeriodValid());
    }

}

// run test case
$testCase = new ConfigParamsTest();
$testCase->run();
