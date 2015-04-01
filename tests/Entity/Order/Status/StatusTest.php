<?php

/*
 * This file is part of submarino-sdk
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Tests\SubmarinoSdk\Entity\Order\Status;

use Gpupo\SubmarinoSdk\Entity\Order\Order;
use Gpupo\Tests\SubmarinoSdk\Entity\Order\OrderTestCaseAbstract;

class StatusTest extends OrderTestCaseAbstract
{
    /**
     * @dataProvider dataProviderOrderCollection
     */
    public function testCadaStatusPossuiObjetoShipped(Order $order)
    {
        $status =  $order->getStatus();
        $this->assertInstanceOf('\Gpupo\SubmarinoSdk\Entity\Order\Status\Shipped', $status->getShipped());
    }

    /**
     * @dataProvider dataProviderOrderCollection
     */
    public function testCadaStatusPossuiObjetoDelivered(Order $order)
    {
        $status =  $order->getStatus();
        $this->assertInstanceOf('\Gpupo\SubmarinoSdk\Entity\Order\Status\Delivered', $status->getDelivered());
    }

    /**
     * @dataProvider dataProviderOrderCollection
     * @expectedException \Gpupo\CommonSdk\Exception\ExceptionInterface
     */
    public function testFalhaAoMarcarComoRemetidoSemPossuirObjetoShippedValido(Order $order)
    {
        $status =  $order->getStatus();
        $status->setStatus('SHIPPED');
        $this->assertFalse($status->isValid());
        echo $status->toJson();
    }

    /**
     * @dataProvider dataProviderOrderCollection
     */
    public function testSucessoAoMarcarComoRemetidoInformandoObjetoShippedValido(Order $order)
    {
        $status =  $order->getStatus();
        $status->setStatus('SHIPPED');
        $status->getShipped()->setEstimatedDelivery('2014-12-01 10:00:00')
            ->setDeliveredCarrierDate(date('Y-m-d H:i:s'));
        $this->assertTrue($status->isValid());
    }

    /**
     * @dataProvider dataProviderOrderCollection
     * @expectedException \Gpupo\CommonSdk\Exception\ExceptionInterface
     */
    public function testFalhaAoMarcarComoEntregueSemPossuirObjetoDeliveredValido(Order $order)
    {
        $status =  $order->getStatus();
        $status->setStatus('DELIVERED');
        $this->assertFalse($status->isValid());
        echo $status->toJson();
    }

    /**
     * @dataProvider dataProviderOrderCollection
     */
    public function testSucessoAoMarcarComoEntregueInformandoObjetoDeliveredValido(Order $order)
    {
        $status =  $order->getStatus();
        $status->setStatus('DELIVERED');
        $status->getDelivered()->setDeliveredCustomerDate(date('Y-m-d H:i:s'));
        $this->assertTrue($status->isValid());
    }
}
