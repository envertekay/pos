<?php
/**
 * @license MIT
 */
namespace Mews\Pos;

use GuzzleHttp\Exception\GuzzleException;
use Mews\Pos\DataMapper\AbstractRequestDataMapper;
use Mews\Pos\Entity\Account\AbstractPosAccount;
use Mews\Pos\Entity\Card\AbstractCreditCard;
use Mews\Pos\Exceptions\UnsupportedPaymentModelException;
use Mews\Pos\Gateways\AbstractGateway;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface PosInterface
 */
interface PosInterface
{
    /**
     * PosInterface constructor.
     *
     * @param array                     $config
     * @param AbstractPosAccount        $account
     * @param AbstractRequestDataMapper $currencies
     */
    public function __construct(array $config, AbstractPosAccount $account, AbstractRequestDataMapper $currencies);

    /**
     * Create XML DOM Document
     *
     * @param array  $nodes
     * @param string $encoding
     * @param bool   $ignorePiNode when true it will not wrap it with this node <?xml version="1.0" encoding="UTF-8"?>
     *
     * @return string the XML, or false if an error occurred.
     */
    public function createXML(array $nodes, string $encoding = 'UTF-8', bool $ignorePiNode = false);

    /**
     * Print Data
     *
     * @param $data
     *
     * @return null|string
     */
    public function printData($data);

    /**
     * Regular Payment
     *
     * @return AbstractGateway
     *
     * @throws GuzzleException
     */
    public function makeRegularPayment();

    /**
     * Make 3D Payment
     * @param Request $request
     *
     * @return AbstractGateway
     *
     * @throws GuzzleException
     */
    public function make3DPayment(Request $request);

    /**
     * Make 3D Pay Payment
     * @param Request $request
     *
     * @return AbstractGateway
     */
    public function make3DPayPayment(Request $request);

    /**
     * Just returns formatted data of host payment response
     * @param Request $request
     *
     * @return AbstractGateway
     */
    public function make3DHostPayment(Request $request);

    /**
     * Send contents to WebService
     *
     * @param array|string $contents
     * @param string|null  $url
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function send($contents, ?string $url = null);

    /**
     * Prepare Order
     *
     * @param array                   $order
     * @param string                  $txType //txTypes from AbstractGateway
     * @param AbstractCreditCard|null $card   need when 3DFormData requested
     *
     * @return void
     */
    public function prepare(array $order, string $txType, $card = null);

    /**
     * Make Payment
     *
     * @param AbstractCreditCard $card
     *
     * @return AbstractGateway
     *
     * @throws UnsupportedPaymentModelException
     * @throws GuzzleException
     */
    public function payment($card);

    /**
     * Refund Order
     *
     * @return AbstractGateway
     *
     * @throws GuzzleException
     */
    public function refund();

    /**
     * Cancel Order
     *
     * @return AbstractGateway
     *
     * @throws GuzzleException
     */
    public function cancel();

    /**
     * Order Status
     *
     * @return AbstractGateway
     *
     * @throws GuzzleException
     */
    public function status();

    /**
     * Order History
     *
     * @param array $meta
     *
     * @return AbstractGateway
     *
     * @throws GuzzleException
     */
    public function history(array $meta);

    /**
     * Is success
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * Is error
     *
     * @return bool
     */
    public function isError();

    /**
     * Enable/Disable test mode
     *
     * @param bool $testMode
     *
     * @return AbstractGateway
     */
    public function setTestMode(bool $testMode);

    /**
     * Enable/Disable test mode
     *
     * @return bool
     */
    public function isTestMode();
}
