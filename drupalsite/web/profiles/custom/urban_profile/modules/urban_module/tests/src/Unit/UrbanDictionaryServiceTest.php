<?php

namespace Drupal\tests\urban_module\Unit;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Tests\UnitTestCase;
use Drupal\urban_module\Service\UrbanDictionaryService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * @coversDefaultClass \Drupal\urban_module\Service\UrbanDictionaryService
 */
class UrbanDictionaryServiceTest extends UnitTestCase {

  /**
   * @covers ::getDefinition
   */
  public function testGetDefinition() {
    $httpClientMock = $this->createMock(ClientInterface::class);
    $httpClientMock->method('request')->willReturn(new JsonResponse([
      'term' => 'coffee',
      'definition' => 'tasty drink',
      'example' => 'I like coffee',
    ]));
    $loggerFactoryMock = $this->createMock(LoggerChannelFactoryInterface::class);
    $loggerMock = $this->createMock(LoggerInterface::class);
    $loggerFactoryMock->method('get')->willReturn($loggerMock);
    $loggerMock->expects($this->never())->method('error');
    $urbanDictionaryService = new UrbanDictionaryService($httpClientMock, $loggerFactoryMock);
    $definition = $urbanDictionaryService->getDefinition('definition');
    $this->assertEquals($definition->getTerm(), 'coffee');
    $this->assertEquals($definition->getDefinition(), 'tasty drink');
    $this->assertEquals($definition->getExample(), 'I like coffee');
  }

  /**
   * @covers ::getDefinition
   */
  public function testGetDefinitionError() {
    $httpClientMock = $this->createMock(ClientInterface::class);
    $requestMock = $this->createMock(RequestInterface::class);
    $httpClientMock->method('request')
      ->willThrowException(new RequestException('Error', $requestMock));
    $loggerFactoryMock = $this->createMock(LoggerChannelFactoryInterface::class);
    $loggerMock = $this->createMock(LoggerInterface::class);
    $loggerFactoryMock->method('get')->willReturn($loggerMock);
    $loggerMock->expects($this->once())->method('error');
    $urbanDictionaryService = new UrbanDictionaryService($httpClientMock, $loggerFactoryMock);
    $definition = $urbanDictionaryService->getDefinition('definition');
    $this->assertNull($definition, NULL);
  }

}
