<?php

namespace App\Http\Livewire\Frontend\Checkout;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CheckoutComponent extends Component
{
    use LivewireAlert;
    
    public $cartSubTotal;
    public $cartTax = 0;
    public $cartTotal;
    public $provinces;
    public $cities;
    public $shippingCosts;

    public $province;
    public $city;
    public $shipping;

    protected $couriers = [
		'jne' => 'JNE',
		'pos' => 'POS Indonesia',
		'tiki' => 'Titipan Kilat'
	];

    public function mount()
    {
        $this->cartSubTotal = getNumbersOfCart()->get('subtotal');
        $this->cartTotal = getNumbersOfCart()->get('total');
        $this->cities = collect();
        $this->shippingCosts = collect();

        $client = new \GuzzleHttp\Client();

		$headers = ['key' => '3a84db1da08146401f5dc3626d0078ce'];
		$requestParams = [
			'headers' => $headers,
        ];
        

        $response = $client->request('GET', "https://api.rajaongkir.com/starter/province", $requestParams);
        
        $response = json_decode($response->getBody(), true);
        
        $province = $response['rajaongkir']['results'];
        $provinces = [];

        if(!empty($province)){
            foreach($province as $province){
                $provinces[$province['province_id']] = strtoupper($province['province']);
            }
        }

        $this->provinces = $provinces;

    }

    public function updatedProvince($provinceId){

        $client = new \GuzzleHttp\Client();

		$headers = ['key' => '3a84db1da08146401f5dc3626d0078ce'];
		$requestParams = [
			'headers' => $headers,
        ];

        $params =  ['province' => $provinceId];
        $query = is_array($params) ? '?'.http_build_query($params) : '';
       
        $response = $client->request("GET", "https://api.rajaongkir.com/starter/city/$query", $requestParams);
        $response = json_decode($response->getBody(), true);
        
        $cityList = $response['rajaongkir']['results'];
        $cities = [];

        if (!empty($cityList)) {
			foreach ($cityList as $city) {
				$cities[$city['city_id']] = strtoupper($city['type'].' '.$city['city_name']);
			}
        }

        $this->cities = $cities;
    }

    public function updatedCity($cityId){
        $params = [
			'origin' => 238,
			'destination' => $cityId,
			'weight' => 500,
		];

		$results = [];
		foreach ($this->couriers as $code => $courier) {

            
            $client = new \GuzzleHttp\Client();
            $params['courier'] = $code;

            $headers = ['key' => '3a84db1da08146401f5dc3626d0078ce'];
            $requestParams = [
                'headers' => $headers,
            ];
            $requestParams['form_params'] = $params;

            $response = $client->request("POST", "https://api.rajaongkir.com/starter/cost", $requestParams);
            $response = json_decode($response->getBody(), true);
			
			if (!empty($response)) {
				foreach ($response['rajaongkir']['results'] as $cost) {
					if (!empty($cost['costs'])) {
						foreach ($cost['costs'] as $costDetail) {
							$serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
							$costAmount = $costDetail['cost'][0]['value'];
							$etd = $costDetail['cost'][0]['etd'];

							$result = [
								'service' => $serviceName,
								'cost' => $costAmount,
								'etd' => $etd,
								'courier' => $code,
							];

							$results[] = $result;
						}
					}
				}
			}
        }

		$response = [
			'origin' => $params['origin'],
			'destination' => $cityId,
			'weight' => 500,
			'results' => $results,
        ];
        
        $this->shippingCosts = $response['results'];
    }

    public function updatedShipping($shippingId){
        $params = [
			'origin' => 238,
			'destination' => $this->city,
			'weight' => 500,
		];

		$results = [];
		foreach ($this->couriers as $code => $courier) {

            
            $client = new \GuzzleHttp\Client();
            $params['courier'] = $code;

            $headers = ['key' => '3a84db1da08146401f5dc3626d0078ce'];
            $requestParams = [
                'headers' => $headers,
            ];
            $requestParams['form_params'] = $params;

            $response = $client->request("POST", "https://api.rajaongkir.com/starter/cost", $requestParams);
            $response = json_decode($response->getBody(), true);
			
			if (!empty($response)) {
				foreach ($response['rajaongkir']['results'] as $cost) {
					if (!empty($cost['costs'])) {
						foreach ($cost['costs'] as $costDetail) {
							$serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
							$costAmount = $costDetail['cost'][0]['value'];
							$etd = $costDetail['cost'][0]['etd'];

							$result = [
								'service' => $serviceName,
								'cost' => $costAmount,
								'etd' => $etd,
								'courier' => $code,
							];

							$results[] = $result;
						}
					}
				}
			}
        }

		$response = [
			'origin' => $params['origin'],
			'destination' => $this->city,
			'weight' => 500,
			'results' => $results,
        ];
        
        $shippingOptions = $response['results'];
        

		$selectedShipping = null;
		if ($shippingOptions) {
			foreach ($shippingOptions as $shippingOption) {
				if (str_replace(' ', '', $shippingOption['service']) == $shippingId) {
					$selectedShipping = $shippingOption;
					break;
				}
			}
        }

		$status = null;
		$message = null;
		$data = [];
		if ($selectedShipping) {
			$status = 200;
			$message = 'Success set shipping cost';

            $this->cartTotal = getNumbersOfCart()->get('total') + $selectedShipping['cost'];
            
		}
    }

    public function render()
    {
        return view('livewire.frontend.checkout.checkout-component');
    }

    public function checkout(){
		
		$order = \DB::transaction(function() use ($params) {
			
			$baseTotalPrice = \Cart::getSubTotal();
			$shippingCost = $selectedShipping['cost'];
			$discountAmount = 0;
			$discountPercent = 0;
			$grandTotal = ($baseTotalPrice + $shippingCost) - $discountAmount;
	
			$orderDate = date('Y-m-d H:i:s');
			$paymentDue = (new \DateTime($orderDate))->modify('+3 day')->format('Y-m-d H:i:s');

			$orderParams = [
				'user_id' => auth()->id(),
				'code' => Order::generateCode(),
				'status' => Order::CREATED,
				'order_date' => $orderDate,
				'payment_due' => $paymentDue,
				'payment_status' => Order::UNPAID,
				'base_total_price' => $baseTotalPrice,
				'discount_amount' => $discountAmount,
				'discount_percent' => $discountPercent,
				'shipping_cost' => $shippingCost,
				'grand_total' => $grandTotal,
				'customer_first_name' => $params['first_name'],
				'customer_last_name' => $params['last_name'],
				'customer_company' => $params['company'],
				'customer_address1' => $params['address1'],
				'customer_address2' => $params['address2'],
				'customer_phone' => $params['phone'],
				'customer_email' => $params['email'],
				'customer_city_id' => $params['city_id'],
				'customer_province_id' => $params['province_id'],
				'customer_postcode' => $params['postcode'],
				'shipping_courier' => $selectedShipping['courier'],
				'shipping_service_name' => $selectedShipping['service'],
			];

			$order = Order::create($orderParams);
			
			$cartItems = \Cart::getContent();

			if ($order && $cartItems) {
				foreach ($cartItems as $item) {
					$itemDiscountAmount = 0;
					$itemDiscountPercent = 0;
					$itemBaseTotal = $item->quantity * $item->price;
					$itemSubTotal = $itemBaseTotal - $itemDiscountAmount;

					$product = isset($item->associatedModel->parent) ? $item->associatedModel->parent : $item->associatedModel;

					$orderItemParams = [
						'order_id' => $order->id,
						'product_id' => $item->associatedModel->id,
						'qty' => $item->quantity,
						'base_price' => $item->price,
						'base_total' => $itemBaseTotal,
						'discount_amount' => $itemDiscountAmount,
						'discount_percent' => $itemDiscountPercent,
						'sub_total' => $itemSubTotal,
						'sku' => $item->associatedModel->sku,
						'type' => $product->type,
						'name' => $item->name,
						'weight' => $item->associatedModel->weight,
						'attributes' => json_encode($item->attributes),
					];

					$orderItem = OrderItem::create($orderItemParams);
				}
			}

			$shippingFirstName = isset($params['ship_to']) ? $params['shipping_first_name'] : $params['first_name'];
			$shippingLastName = isset($params['ship_to']) ? $params['shipping_last_name'] : $params['last_name'];
			$shippingCompany = isset($params['ship_to']) ? $params['shipping_company'] :$params['company'];
			$shippingAddress1 = isset($params['ship_to']) ? $params['shipping_address1'] : $params['address1'];
			$shippingAddress2 = isset($params['ship_to']) ? $params['shipping_address2'] : $params['address2'];
			$shippingPhone = isset($params['ship_to']) ? $params['shipping_phone'] : $params['phone'];
			$shippingEmail = isset($params['ship_to']) ? $params['shipping_email'] : $params['email'];
			$shippingCityId = isset($params['ship_to']) ? $params['shipping_city_id'] : $params['city_id'];
			$shippingProvinceId = isset($params['ship_to']) ? $params['shipping_province_id'] : $params['province_id'];
			$shippingPostcode = isset($params['ship_to']) ? $params['shipping_postcode'] : $params['postcode'];

			$shipmentParams = [
				'user_id' => auth()->id(),
				'order_id' => $order->id,
				'status' => Shipment::PENDING,
				'total_qty' => \Cart::getTotalQuantity(),
				'total_weight' => $totalWeight,
				'first_name' => $shippingFirstName,
				'last_name' => $shippingLastName,
				'shipping_company' => $shippingCompany,
				'address1' => $shippingAddress1,
				'address2' => $shippingAddress2,
				'phone' => $shippingPhone,
				'email' => $shippingEmail,
				'city_id' => $shippingCityId,
				'province_id' => $shippingProvinceId,
				'postcode' => $shippingPostcode,
			];
			Shipment::create($shipmentParams);

			return $order;
		});
    }
}
