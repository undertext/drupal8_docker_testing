<?php

namespace Drupal\urban_module\Service;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\urban_module\Model\UrbanDefinition;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Allows to request Urban Dictionary API.
 */
class UrbanDictionaryService implements UrbanDictionaryServiceInterface {

  /**
   * Client for sending HTTP requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  private $httpClient;

  /**
   * Logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  private $logger;

  /**
   * UrbanDictionaryService constructor.
   *
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   Client for sending HTTP requests.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerChannelFactory
   *   Logger channel factory.
   */
  public function __construct(ClientInterface $httpClient, LoggerChannelFactoryInterface $loggerChannelFactory) {
    $this->httpClient = $httpClient;
    $this->logger = $loggerChannelFactory->get('urban_dictionary');
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinition($term) {
    try {
      $response = $this->httpClient->request('GET', "http://urbanscraper.herokuapp.com/define/$term");
    } catch (GuzzleException $e) {
      $this->logger->error($e->getMessage());
      return NULL;
    }
    $json = json_decode($response->getBody());
    return new UrbanDefinition($json->term, $json->definition, $json->example);
  }

}
