<?php

namespace wndr\commerce\afterpay\gateways;

use craft\commerce\base\Gateway as BaseGateway;
use Craft;
use craft\commerce\base\RequestResponseInterface;
use craft\commerce\elements\Order;
use craft\commerce\models\payments\BasePaymentForm;
use craft\commerce\models\PaymentSource;
use craft\commerce\models\Transaction;
use craft\web\Response as WebResponse;
use wndr\commerce\afterpay\Afterpay;
use Afterpay\Afterpay as AfterpayClient;
use wndr\commerce\afterpay\models\forms\PaymentForm;
use wndr\commerce\afterpay\transformers\OrderTransformer;
use yii\base\NotSupportedException;

class Gateway extends BaseGateway
{

    public $merchantId;
    public $merchantKey;
    public $portfolioId;
    public $merchantReference;
    public $gatewayType = 'B2C';
    public $sandboxMode = false;

    public static function displayName(): string
    {
        return Craft::t('commerce', 'Afterpay');
    }

    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('commerce-afterpay-v3/gateway/settings.twig.html', ['gateway' => $this]);
    }

    public function getPaymentTypeOptions(): array
    {
        return [
            'purchase' => Craft::t('commerce', 'Purchase (Authorize and Capture Immediately)'),
        ];
    }

    public function getPaymentFormHtml(array $params): ?string
    {
        return null;
    }

    public function getPaymentFormModel(): BasePaymentForm
    {
        return new PaymentForm();
    }

    public function supportsPurchase(): bool
    {
        return true;
    }

    public function purchase(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        $client = new AfterpayClient();
        $client->setRest();

        /** @var Order $order **/
        $order = $transaction->getOrder();
        $apiOrder = (new OrderTransformer())->transform($order);

        foreach($order->lineItems as $line) {
            $client->create_order_line(
                $line->getSku(),
                $line->getDescription(),
                $line->qty,
                $line->salePrice / 100,
                $line->taxCategoryId,
                $line->taxIncluded
            );
        }

        // Create the order object for B2C or B2B
        $client->set_order($apiOrder, $this->gatewayType);


        $client->do_request(
            [
                'merchantid' => (int)Craft::parseEnv($this->merchantId),
                'portfolioid' => (int)Craft::parseEnv($this->portfolioId),
                'password' => (int)Craft::parseEnv($this->merchantKey),
                'apiKey' => '707EA1C801E8B0B31BCC641692C257CC'
            ],
            ($this->sandboxMode ? 'test' : 'live')
        );

        dd('here');
        // TODO: Implement purchase() method.
    }

    public function supportsCompletePurchase(): bool
    {
        return true;
    }

    public function completePurchase(Transaction $transaction): RequestResponseInterface
    {
        // TODO: Implement completePurchase() method.
    }

    public function supportsAuthorize(): bool
    {
        return false;
    }

    public function authorize(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        throw new NotSupportedException(Craft::t('commerce', 'Authorization is not supported by this gateway'));
    }

    public function supportsRefund(): bool
    {
        return false;
    }

    public function refund(Transaction $transaction): RequestResponseInterface
    {
        throw new NotSupportedException(Craft::t('commerce', 'Payment sources are not supported by this gateway'));
    }

    public function supportsPaymentSources(): bool
    {
        return false;
    }

    public function createPaymentSource(BasePaymentForm $sourceData, int $userId): PaymentSource
    {
        throw new NotSupportedException(Craft::t('commerce', 'Payment sources are not supported by this gateway'));
    }

    public function supportsWebhooks(): bool
    {
        return false;
    }

    public function processWebHook(): WebResponse
    {
        throw new NotSupportedException(Craft::t('commerce', 'Webhooks are not supported by this gateway'));
    }

    public function deletePaymentSource($token): bool
    {
        throw new NotSupportedException(Craft::t('commerce', 'Payment sources are not supported by this gateway'));
    }


    public function supportsCompleteAuthorize(): bool
    {
        return false;
    }

    public function completeAuthorize(Transaction $transaction): RequestResponseInterface
    {
        throw new NotSupportedException(Craft::t('commerce', 'Complete Authorize is not supported by this gateway'));
    }

    public function supportsCapture(): bool
    {
        return false;
    }

    public function capture(Transaction $transaction, string $reference): RequestResponseInterface
    {
        throw new NotSupportedException(Craft::t('commerce', 'Capture is not supported by this gateway'));
    }

    public function supportsPartialRefund(): bool
    {

        // TODO implement refund
        return false;
    }
}