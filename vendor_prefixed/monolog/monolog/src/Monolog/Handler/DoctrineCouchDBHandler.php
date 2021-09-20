<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FPFProVendor\Monolog\Handler;

use FPFProVendor\Monolog\Logger;
use FPFProVendor\Monolog\Formatter\NormalizerFormatter;
use FPFProVendor\Doctrine\CouchDB\CouchDBClient;
/**
 * CouchDB handler for Doctrine CouchDB ODM
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class DoctrineCouchDBHandler extends \FPFProVendor\Monolog\Handler\AbstractProcessingHandler
{
    private $client;
    public function __construct(\FPFProVendor\Doctrine\CouchDB\CouchDBClient $client, $level = \FPFProVendor\Monolog\Logger::DEBUG, $bubble = \true)
    {
        $this->client = $client;
        parent::__construct($level, $bubble);
    }
    /**
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        $this->client->postDocument($record['formatted']);
    }
    protected function getDefaultFormatter()
    {
        return new \FPFProVendor\Monolog\Formatter\NormalizerFormatter();
    }
}
